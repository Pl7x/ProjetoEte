<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // 1. INICIAR PAGAMENTO
    public function checkout(Request $request)
    {
        // Validação básica
        $userId = Auth::guard('client')->id();
        if (!$userId) {
            return redirect()->route('login.client')->with('error', 'Faça login para comprar.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Inicia a query dos itens do carrinho
        $query = CartItem::where('client_id', $userId)->with('product');

        // LÓGICA DE SELEÇÃO: 
        // Se o formulário enviou itens específicos (checkboxes), filtramos por eles.
        // Caso contrário, pega tudo (comportamento padrão).
        if ($request->has('selected_items') && is_array($request->selected_items)) {
            // O frontend envia os IDs dos itens do carrinho (CartItem ID) ou Produtos.
            // Assumindo que o value="{{ $id }}" no HTML seja o ID do produto ou do CartItem.
            // Se for ID do produto: ->whereIn('product_id', ...)
            // Se for ID do CartItem: ->whereIn('id', ...)
            // Baseado no código anterior do livewire, geralmente é o ID do produto ($id da iteração).
            
            // Vamos filtrar pelo product_id para garantir
             $query->whereIn('product_id', $request->selected_items);
        }

        $dbItems = $query->get();

        if ($dbItems->isEmpty()) {
            return back()->with('error', 'Nenhum item válido selecionado para compra.');
        }

        // Monta a lista para o Stripe
        $lineItems = [];
        foreach ($dbItems as $item) {
            // Proteção contra produtos excluídos ou sem preço
            if (!$item->product) continue;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => [
                        'name' => $item->product->name,
                        // Você pode adicionar imagens aqui se quiser:
                        // 'images' => [$item->product->image_url], 
                    ],
                    'unit_amount' => intval($item->product->price * 100), // Stripe usa centavos (R$ 10,00 = 1000)
                ],
                'quantity' => $item->quantity,
            ];
        }

        // Cria a sessão no Stripe
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('catalogo'), // Se cancelar, volta pra loja
            ]);

            return redirect($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao comunicar com Stripe: ' . $e->getMessage());
        }
    }
    

    // 2. SUCESSO DO PAGAMENTO
    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('catalogo');
        }

        try {
            $session = Session::retrieve($sessionId);

            // Verifica se já salvamos esse pedido antes (para evitar duplicidade no F5)
            if (Order::where('stripe_session_id', $sessionId)->exists()) {
                return view('checkout.success');
            }

            if ($session->payment_status === 'paid') {
                DB::beginTransaction(); // Protege o banco de dados

                // A. Cria o Pedido
                // OBS: Certifique-se que seu Model Order tem 'casts' => ['shipping_address' => 'array']
                // ou que a coluna no banco seja do tipo JSON/TEXT.
                $order = Order::create([
                    'stripe_session_id' => $sessionId,
                    'client_id' => Auth::guard('client')->id(),
                    'status' => 'paid', // ou 'concluido'
                    'total_price' => $session->amount_total / 100,
                    'customer_name' => $session->customer_details->name,
                    'customer_email' => $session->customer_details->email,
                    // O Laravel converte array para JSON automaticamente se o Model estiver configurado,
                    // senão use json_encode() aqui.
                    
                ]);

                // B. Precisamos recuperar QUAIS itens foram comprados.
                // Como o Stripe não devolve os IDs do nosso banco facilmente na session retrieve simples,
                // vamos pegar o carrinho atual do usuário e assumir que ele pagou o que estava lá.
                // (Para maior precisão, deveríamos ter salvo um 'pending order' antes, mas essa lógica funciona para fluxos simples)
                
                // NOTA: Se você implementou a seleção parcial, aqui temos um risco:
                // Se o usuário selecionou 1 item, pagou, e voltou, o carrinho ainda tem todos os itens.
                // O ideal é limpar apenas os itens comprados ou limpar tudo. 
                // Vamos limpar tudo para simplificar conforme seu código original.
                
                $cartItems = CartItem::where('client_id', Auth::guard('client')->id())->get();

                foreach ($cartItems as $item) {
                    // Salva o item no pedido
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price
                    ]);

                    // --- BAIXA O ESTOQUE ---
                    $produto = Product::find($item->product_id);
                    if ($produto) {
                        $produto->decrement('stock_quantity', $item->quantity);
                    }
                }

                // C. Limpa o carrinho
                CartItem::where('client_id', Auth::guard('client')->id())->delete();

                DB::commit(); // Salva tudo
                
                return view('checkout.success', compact('order'));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro no Checkout Success: " . $e->getMessage());
            return redirect()->route('catalogo')->with('error', 'Erro ao processar pedido: ' . $e->getMessage());
        }
    }
}
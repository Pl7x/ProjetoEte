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
        $user = Auth::guard('client')->user();
        if (!$user) {
            return redirect()->route('login.client')->with('error', 'Faça login para comprar.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Query itens do carrinho
        $query = CartItem::where('client_id', $user->id)->with('product');

        // Filtro de seleção (se houver)
        if ($request->has('selected_items') && is_array($request->selected_items)) {
             $query->whereIn('product_id', $request->selected_items);
        }

        $dbItems = $query->get();

        if ($dbItems->isEmpty()) {
            return back()->with('error', 'Nenhum item válido selecionado.');
        }

        // Monta lista Stripe e guarda snapshot dos itens para o retorno
        $lineItems = [];
        $itemsMeta = []; // Vamos salvar IDs e Qtd no metadata para garantir recuperação

        foreach ($dbItems as $item) {
            if (!$item->product) continue;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => ['name' => $item->product->name],
                    'unit_amount' => intval($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];

            // Guarda info mínima para reconstruir o pedido no retorno
            $itemsMeta[] = $item->product_id . ':' . $item->quantity;
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('catalogo'),
                // METADADOS IMPORTANTES: Salvam o contexto mesmo se a sessão cair
                'metadata' => [
                    'client_id' => $user->id,
                    'items_snapshot' => json_encode($itemsMeta) // Salva "1:2,5:1" (ProdID:Qtd)
                ],
                'customer_email' => $user->email, // Pré-preenche ementa no Stripe
            ]);

            return redirect($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro Stripe: ' . $e->getMessage());
        }
    }
    

    // 2. SUCESSO DO PAGAMENTO
    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');

        if (!$sessionId) return redirect()->route('catalogo');

        try {
            $session = Session::retrieve($sessionId);

            // Evita duplicidade
            if (Order::where('stripe_session_id', $sessionId)->exists()) {
                return redirect()->route('home')->with('info', 'Pedido já processado.');
            }

            if ($session->payment_status === 'paid') {
                DB::beginTransaction();

                // RECUPERA O CLIENTE DOS METADADOS (Mais seguro que Auth::user())
                $clientId = $session->metadata->client_id ?? Auth::guard('client')->id();
                
                // Cria o Pedido
                $order = Order::create([
                    'stripe_session_id' => $sessionId,
                    'client_id' => $clientId, // Usa o ID recuperado
                    'status' => 'paid',
                    'total_price' => $session->amount_total / 100,
                    'customer_name' => $session->customer_details->name ?? 'Cliente',
                    'customer_email' => $session->customer_details->email,
                ]);

                // RECUPERA ITENS: Tenta pelo carrinho primeiro, fallback para metadata
                // Isso garante que mesmo se o carrinho for limpo ou sessão perdida, temos os itens
                $cartItems = CartItem::where('client_id', $clientId)->get();
                
                if ($cartItems->isNotEmpty()) {
                    // Fluxo normal: Carrinho ainda existe
                    foreach ($cartItems as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->product->price // Preço atual do banco
                        ]);
                        
                        Product::find($item->product_id)?->decrement('stock_quantity', $item->quantity);
                    }
                    // Limpa carrinho
                    CartItem::where('client_id', $clientId)->delete();
                } 
                else {
                    // Fluxo de Segurança: Carrinho vazio? Usa os metadados do Stripe!
                    // Formato salvo: ["1:2", "5:1"] (ProdID:Qtd)
                    if (isset($session->metadata->items_snapshot)) {
                        $itemsData = json_decode($session->metadata->items_snapshot);
                        if (is_array($itemsData)) {
                            foreach ($itemsData as $itemStr) {
                                [$prodId, $qty] = explode(':', $itemStr);
                                $prod = Product::find($prodId);
                                if ($prod) {
                                    OrderItem::create([
                                        'order_id' => $order->id,
                                        'product_id' => $prodId,
                                        'quantity' => $qty,
                                        'price' => $prod->price 
                                    ]);
                                    $prod->decrement('stock_quantity', $qty);
                                }
                            }
                        }
                    }
                }

                DB::commit();
                return redirect()->route('home')->with('success', 'Pedido confirmado! #' . $order->id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro Checkout: " . $e->getMessage());
            // Se der erro, mostre na tela para debug (em produção, redirecione com flash)
            return redirect()->route('catalogo')->with('error', 'Erro ao finalizar: ' . $e->getMessage());
        }
        
        return redirect()->route('catalogo');
    }
}
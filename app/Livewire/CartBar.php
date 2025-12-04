<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
// IMPORTS OBRIGATÓRIOS DO MERCADO PAGO
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class CartBar extends Component
{
    public $cart = [];
    public $selectedItems = [];
    public $total = 0;

    public function mount()
    {
        $this->refreshCart();
        $this->selectedItems = array_keys($this->cart); // Seleciona tudo por padrão ao iniciar
        $this->calculateTotal();
    }

    #[On('cart-updated')]
    public function refreshCart()
    {
        $oldIds = array_keys($this->cart);

        if (Auth::guard('client')->check()) {
            $dbItems = CartItem::where('client_id', Auth::guard('client')->id())
                                ->with('product')
                                ->get();
            
            $this->cart = [];
            foreach ($dbItems as $item) {
                // Proteção caso o produto tenha sido deletado
                if ($item->product) {
                    $this->cart[$item->product_id] = [
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'image' => $item->product->image_path
                    ];
                }
            }
        } 
        else {
            $this->cart = session()->get('cart', []);
        }

        // Mantém seleção
        $currentIds = array_keys($this->cart);
        $newItems = array_diff($currentIds, $oldIds);
        $this->selectedItems = array_intersect($this->selectedItems, $currentIds);
        $this->selectedItems = array_merge($this->selectedItems, $newItems);

        $this->calculateTotal();
    }

    public function updatedSelectedItems() { $this->calculateTotal(); }
    
    public function calculateTotal() {
        $this->total = 0;
        foreach ($this->cart as $id => $item) {
            if (in_array($id, $this->selectedItems)) {
                $this->total += $item['price'] * $item['quantity'];
            }
        }
    }

    public function increment($productId)
    {
        if (Auth::guard('client')->check()) {
            CartItem::where('client_id', Auth::guard('client')->id())
                    ->where('product_id', $productId)
                    ->increment('quantity');
        } else {
            if(isset($this->cart[$productId])) {
                $this->cart[$productId]['quantity']++;
                session()->put('cart', $this->cart);
            }
        }
        $this->dispatch('cart-updated');
    }

    public function decrement($productId)
    {
        if (Auth::guard('client')->check()) {
            $item = CartItem::where('client_id', Auth::guard('client')->id())
                            ->where('product_id', $productId)->first();
            if ($item) {
                if ($item->quantity > 1) {
                    $item->decrement('quantity');
                } else {
                    $item->delete();
                }
            }
        } else {
            if (isset($this->cart[$productId])) {
                if ($this->cart[$productId]['quantity'] > 1) {
                    $this->cart[$productId]['quantity']--;
                } else {
                    unset($this->cart[$productId]);
                }
                session()->put('cart', $this->cart);
            }
        }
        $this->dispatch('cart-updated');
    }

    public function remove($productId)
    {
        if (Auth::guard('client')->check()) {
            CartItem::where('client_id', Auth::guard('client')->id())
                    ->where('product_id', $productId)
                    ->delete();
        } else {
            unset($this->cart[$productId]);
            session()->put('cart', $this->cart);
        }
        
        $key = array_search($productId, $this->selectedItems);
        if ($key !== false) unset($this->selectedItems[$key]);
        
        $this->dispatch('cart-updated');
    }

    // --- AÇÃO DE PAGAMENTO ---
    public function finalizeOrder()
    {
        // Validações
        if (empty($this->selectedItems)) {
            // Opcional: emitir aviso visual
            return;
        }

        if (!Auth::guard('client')->check()) {
            $this->dispatch('open-auth-modal');
            return;
        }

        // Configuração do Token (OBRIGATÓRIO TER NO .ENV)
        $token = env('MERCADOPAGO_ACCESS_TOKEN');
        if (!$token) {
            dd("ERRO: Token do Mercado Pago não encontrado no arquivo .env");
        }
        MercadoPagoConfig::setAccessToken($token);

        $items = [];
        foreach ($this->cart as $id => $item) {
            if (in_array($id, $this->selectedItems)) {
                $items[] = [
                    "id" => (string)$id,
                    "title" => $item['name'],
                    "quantity" => (int)$item['quantity'],
                    "unit_price" => (float)$item['price'],
                    "currency_id" => "BRL",
                    "picture_url" => $item['image'] ? asset('storage/' . $item['image']) : null,
                ];
            }
        }

        try {
            // ... (código de criação da preferência continua igual) ...
            $client = new PreferenceClient();
            $preference = $client->create([
                "items" => $items,
                "payer" => [
                    // Lembre-se: use um e-mail diferente do dono da conta MP
                    "email" => "cliente_teste_123@testuser.com", 
                ],
                // CORREÇÃO AQUI: URLs explícitas e completas
                "back_urls" => [
                    "success" => "http://127.0.0.1:8000/checkout/success",
                    "failure" => "http://127.0.0.1:8000/checkout/failure",
                    "pending" => "http://127.0.0.1:8000/checkout/pending",
                ],
                "auto_return" => "approved",
            ]);

            return redirect($preference->init_point);

        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            // AQUI ESTÁ O SEGREDO: Pegar o conteúdo da resposta da API
            $response = $e->getApiResponse();
            dd($response->getContent()); 
            
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function render() { return view('livewire.cart-bar'); }
}
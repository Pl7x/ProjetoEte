<?php

namespace App\Livewire;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CartBar extends Component
{
    public $cart = [];
    public $selectedItems = [];
    public $total = 0;

    public function mount()
    {
        $this->refreshCart();
        $this->selectedItems = array_keys($this->cart);
        $this->calculateTotal();
    }

    #[On('cart-updated')]
    public function refreshCart()
    {
        $oldIds = array_keys($this->cart);

        // SE LOGADO: Lê do Banco
        if (Auth::guard('client')->check()) {
            $dbItems = CartItem::where('client_id', Auth::guard('client')->id())
                                ->with('product')
                                ->get();
            
            $this->cart = [];
            foreach ($dbItems as $item) {
                $this->cart[$item->product_id] = [
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'image' => $item->product->image_path
                ];
            }
        } 
        // SE VISITANTE: Lê da Sessão
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

    // --- AÇÕES AGORA VERIFICAM LOGIN ---

    public function increment($productId)
    {
        if (Auth::guard('client')->check()) {
            CartItem::where('client_id', Auth::guard('client')->id())
                    ->where('product_id', $productId)
                    ->increment('quantity');
        } else {
            $this->cart[$productId]['quantity']++;
            session()->put('cart', $this->cart);
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
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
            } else {
                unset($this->cart[$productId]);
            }
            session()->put('cart', $this->cart);
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

    

    public function render() { return view('livewire.cart-bar'); }
}
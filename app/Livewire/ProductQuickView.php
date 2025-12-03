<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductQuickView extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($productId)
    {
        $this->product = Product::find($productId);
    }

    // Validação do campo digitável
    public function updatedQuantity()
    {
        if (!$this->quantity || $this->quantity < 1) $this->quantity = 1;
        if ($this->quantity > $this->product->stock_quantity) $this->quantity = $this->product->stock_quantity;
    }

    public function increment() {
        if ($this->quantity < $this->product->stock_quantity) $this->quantity++;
    }

    public function decrement() {
        if ($this->quantity > 1) $this->quantity--;
    }

    public function addToCart()
    {
        // 1. Validações
        $this->updatedQuantity();

        // 2. SE LOGADO: Salva no Banco
        if (Auth::guard('client')->check()) {
            $item = \App\Models\CartItem::where('client_id', Auth::guard('client')->id())
                        ->where('product_id', $this->product->id)
                        ->first();
            
            if ($item) {
                $item->quantity += $this->quantity;
                $item->save();
            } else {
                \App\Models\CartItem::create([
                    'client_id' => Auth::guard('client')->id(),
                    'product_id' => $this->product->id,
                    'quantity' => $this->quantity
                ]);
            }
        } 
        // 3. SE VISITANTE: Salva na Sessão (Mas o botão QuickView atual
        //    pode bloquear isso se você manteve o bloqueio. 
        //    Se você tirou o bloqueio para permitir adicionar como visitante, use isto:)
        else {
            $cart = session()->get('cart', []);
            $id = $this->product->id;

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $this->quantity;
            } else {
                $cart[$id] = [
                    'name' => $this->product->name,
                    'price' => $this->product->price,
                    'quantity' => $this->quantity,
                    'image' => $this->product->image_path
                ];
            }
            session()->put('cart', $cart);
        }

        // 4. Feedback
        $this->dispatch('cart-updated');
        $this->dispatch('close-quick-view');
        $this->dispatch('open-cart');
        
        $this->quantity = 1;
    }

    public function render()
    {
        return view('livewire.product-quick-view');
    }
}
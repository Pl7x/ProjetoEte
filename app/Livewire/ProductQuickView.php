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
        // 1. VERIFICAÇÃO DE LOGIN
        if (!Auth::guard('client')->check()) {
            // Fecha o QuickView e abre o Login
            $this->dispatch('close-quick-view');
            $this->dispatch('open-auth-modal');
            return;
        }

        // 2. ADICIONAR AO CARRINHO
        $this->updatedQuantity(); // Garante que o número está certo
        
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

        // 3. FEEDBACK
        $this->dispatch('cart-updated');
        $this->dispatch('close-quick-view');
        $this->dispatch('open-cart'); // Abre o carrinho lateral
        
        
        $this->quantity = 1;
    }

    public function render()
    {
        return view('livewire.product-quick-view');
    }
}
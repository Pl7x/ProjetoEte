<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductQuickView extends Component
{
    public $product = null;
    public $quantity = 1;
    public $productId = null;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->loadProduct();
    }

    public function loadProduct()
    {
        $this->product = Product::find($this->productId);
        $this->quantity = 1;
    }

    // MUDANÇA AQUI: Validação quando o usuário digita
    // Este método é chamado automaticamente pelo Livewire quando 'quantity' muda
    public function updatedQuantity($value)
    {
        // 1. Converte para inteiro (remove letras se houver)
        $intValue = intval($value);

        // 2. Garante que o valor seja pelo menos 1. Se for menor, força para 1.
        if ($intValue < 1) {
            $this->quantity = 1;
        } else {
            $this->quantity = $intValue;
        }
    }

    // Mantivemos os métodos de clique, mas agora eles respeitam a mesma lógica
    public function increment() { $this->quantity++; }

    public function decrement() {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.product-quick-view');
    }
}
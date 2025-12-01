<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductQuickView extends Component
{
    public $product = null;
    public $quantity = 1;
    public $productId = null;

    // O método mount e loadProduct permanecem iguais
    public function mount($productId)
    {
        $this->productId = $productId;
        $this->loadProduct();
    }

    public function loadProduct()
    {
        $this->product = Product::find($this->productId);
        // Reseta a quantidade para 1 ao carregar, ou 0 se não tiver estoque
        $this->quantity = ($this->product && $this->product->stock_quantity > 0) ? 1 : 0;
        $this->resetErrorBag();
    }

    // --- NOVO: Propriedade Computada para o Preço Total ---
    // No Livewire, métodos getXProperty são acessados na view como $this->X
    public function getTotalPriceProperty()
    {
        // Se não tiver produto ou a quantidade for inválida, retorna 0
        if (!$this->product || !is_numeric($this->quantity) || $this->quantity < 1) {
            return 0;
        }

        // Calcula: Preço Unitário * Quantidade Atual
        return $this->product->price * intval($this->quantity);
    }
    // ------------------------------------------------------

    // Validação atualizada para permitir o feedback visual vermelho
    public function updatedQuantity($value)
    {
        $this->resetErrorBag('quantity');
        $intValue = intval($value);
        $stock = $this->product->stock_quantity;

        if ($intValue < 1) {
            $this->quantity = 1;
            // Se o estoque for 0, força 0
            if($stock === 0) $this->quantity = 0;

        } elseif ($intValue > $stock) {
            // MUDANÇA: Permitimos que a variável $quantity fique maior que o estoque
            // momentaneamente para que o input fique vermelho na view.
            $this->quantity = $intValue;
            // Adicionamos o erro
            $this->addError('quantity', "Estoque insuficiente. Máximo: {$stock}.");
        } else {
            $this->quantity = $intValue;
        }
    }

    public function increment()
    {
        $this->resetErrorBag('quantity');
        // Só incrementa se for menor que o estoque
        if ($this->quantity < $this->product->stock_quantity) {
            $this->quantity++;
        }
        // Se tentar incrementar no limite, a validação visual na view cuidará do resto
    }

    public function decrement()
    {
        $this->resetErrorBag('quantity');
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.product-quick-view');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CartBar extends Component
{
    public $cart = [];
    public $selectedItems = []; // Itens marcados com checkbox
    public $total = 0;

    public function mount()
    {
        $this->refreshCart();
        // Seleciona todos ao carregar
        $this->selectedItems = array_keys($this->cart);
        $this->calculateTotal();
    }

    #[On('cart-updated')]
    public function refreshCart()
    {
        $oldIds = array_keys($this->cart);
        $this->cart = session()->get('cart', []);
        $currentIds = array_keys($this->cart);

        // Mantém seleção antiga e adiciona novos itens à seleção
        $newItems = array_diff($currentIds, $oldIds);
        $this->selectedItems = array_intersect($this->selectedItems, $currentIds);
        $this->selectedItems = array_merge($this->selectedItems, $newItems);

        $this->calculateTotal();
    }

    public function updatedSelectedItems()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $id => $item) {
            if (in_array($id, $this->selectedItems)) {
                $this->total += $item['price'] * $item['quantity'];
            }
        }
    }

    public function increment($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
            $this->updateSession();
        }
    }

    public function decrement($productId)
    {
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
            } else {
                $this->remove($productId);
                return;
            }
            $this->updateSession();
        }
    }

    public function remove($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            
            $key = array_search($productId, $this->selectedItems);
            if ($key !== false) unset($this->selectedItems[$key]);
            
            $this->updateSession();
        }
    }

    public function updateSession()
    {
        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->dispatch('cart-updated');
        
    }

    public function render()
    {
        return view('livewire.cart-bar');
    }
}
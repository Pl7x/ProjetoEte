<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CartIcon extends Component
{
    public $count = 0;

    public function mount()
    {
        // Carrega a contagem inicial ao abrir a página
        $this->updateCount();
    }

    #[On('cart-updated')] 
    public function updateCount()
    {
        // Atualiza a propriedade lendo a sessão
        $this->count = count(session('cart', []));
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
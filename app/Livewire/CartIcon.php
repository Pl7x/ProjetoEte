<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CartIcon extends Component
{
    #[On('cart-updated')] 
    public function render()
    {
        return view('livewire.cart-icon');
    }
}
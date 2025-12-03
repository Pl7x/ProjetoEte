<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem; // Importante para contar do banco

class CartIcon extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('cart-updated')] 
    public function updateCount()
    {
        if (Auth::guard('client')->check()) {
            // SE LOGADO: Conta quantos itens tem no banco de dados para este cliente
            $this->count = CartItem::where('client_id', Auth::guard('client')->id())->count();
            
            // DICA: Se quiser somar a quantidade total de produtos (ex: 2 camisas + 1 calça = 3),
            // troque ->count() por ->sum('quantity');
        } else {
            // SE VISITANTE: Conta quantos itens tem na sessão
            $this->count = count(session('cart', []));
        }
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
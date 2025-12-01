<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class Carrinho extends Component
{
    // Ouve eventos para atualizar a lista se algo mudar
    protected $listeners = ['cart-updated' => '$refresh'];

    public function increment($id)
    {
        $item = CartItem::where('id', $id)->where('client_id', Auth::guard('client')->id())->first();
        if ($item) {
            $item->increment('quantity');
        }
    }

    public function decrement($id)
    {
        $item = CartItem::where('id', $id)->where('client_id', Auth::guard('client')->id())->first();
        if ($item && $item->quantity > 1) {
            $item->decrement('quantity');
        }
    }

    public function remove($id)
    {
        $item = CartItem::where('id', $id)->where('client_id', Auth::guard('client')->id())->first();
        if ($item) {
            $item->delete();
            $this->dispatch('alert', type: 'success', message: 'Item removido.');
            $this->dispatch('cart-updated'); // Atualiza contador do header se houver
        }
    }

    public function render()
    {
        // Busca apenas os itens do cliente logado
        $items = CartItem::with('product')
                        ->where('client_id', Auth::guard('client')->id())
                        ->get();

        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);

        return view('livewire.carrinho', [
            'items' => $items,
            'total' => $total
        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order; // Importe o Model Order

class ListaPedidos extends Component
{
    use WithPagination;

    public function render()
    {
        // Busca os pedidos ordenados por data (mais recente primeiro)
        // Usa paginação para não carregar tudo de uma vez
        $orders = Order::latest()->paginate(10);

        return view('livewire.lista-pedidos', [
            'orders' => $orders
        ]);
    }
}
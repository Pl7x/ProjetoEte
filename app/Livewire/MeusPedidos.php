<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class MeusPedidos extends Component
{
    use WithPagination;

    public $selectedOrder = null;

    public function render()
    {
        // Busca pedidos do cliente logado, ordenados do mais recente
        $orders = Order::where('client_id', Auth::guard('client')->id())
                        ->latest()
                        ->paginate(6); // 6 cards por página fica visualmente melhor

        // AQUI ESTÁ A CORREÇÃO:
        return view('livewire.meus-pedidos', [
            'orders' => $orders
        ])->layout('layouts.app'); // <--- Define o layout correto aqui
    }

    public function selectOrder($orderId)
    {
        // Carrega o pedido e os produtos para o modal
        $this->selectedOrder = Order::with(['items.product'])
            ->where('client_id', Auth::guard('client')->id())
            ->where('id', $orderId)
            ->firstOrFail();
    }
}
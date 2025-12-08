<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class ListaPedidos extends Component
{
    use WithPagination;

    public $selectedOrder = null;

    // Seleciona o pedido para o Modal
    public function selectOrder($orderId)
    {
        $this->selectedOrder = Order::with(['items.product', 'client'])->find($orderId);
    }

    // Marca como enviado e SALVA A DATA
    public function markAsShipped()
    {
        if ($this->selectedOrder) {
            $this->selectedOrder->update([
                'status' => 'shipped',
                'shipped_at' => now(), // <--- Salva a data e hora atual
            ]);
            
            // Atualiza a visualização do modal
            $this->selectedOrder->refresh();
            
            // Opcional: Feedback visual
            $this->dispatch('order-updated'); 
        }
    }

    public function render()
    {
        $orders = Order::latest()->paginate(10);
        return view('livewire.lista-pedidos', ['orders' => $orders]);
    }
}
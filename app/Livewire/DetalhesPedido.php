<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class DetalhesPedido extends Component
{
    public $order;

    public function mount($id)
    {
        // Busca o pedido trazendo também o cliente e os itens (com os produtos)
        $this->order = Order::with(['client', 'items.product'])->findOrFail($id);
    }

    public function marcarComoEnviado()
    {
        // Atualiza o status para 'enviado' (ou 'shipped')
        $this->order->update([
            'status' => 'enviado'
        ]);

        session()->flash('success', 'Pedido marcado como enviado com sucesso!');
    }

    public function render()
    {
        return view('livewire.admin.detalhes-pedido');
    }
}
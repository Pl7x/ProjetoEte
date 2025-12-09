<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MeusPedidos extends Component
{
    public function render()
    {
        $orders = [];

        if (Auth::guard('client')->check()) {
            $orders = Order::where('client_id', Auth::guard('client')->id())
                ->with(['items.product']) // Carrega os itens e produtos
                ->latest()
                ->get();
        }

        return view('livewire.meus-pedidos', ['orders' => $orders]);
    }
}
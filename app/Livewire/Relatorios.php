<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class Relatorios extends Component
{
    public function render()
    {
        // 1. Totais Gerais (Considerando pagos e enviados como receita real)
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped'])->sum('total_price');
        $totalOrders = Order::count();
        $averageTicket = $totalOrders > 0 ? $totalRevenue / Order::whereIn('status', ['paid', 'shipped'])->count() : 0;

        // 2. Contagem por Status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // 3. Top 5 Produtos Mais Vendidos
        $topProducts = OrderItem::select('product_id', DB::raw('sum(quantity) as total_qty'), DB::raw('sum(price * quantity) as total_revenue'))
            ->with('product') // Carrega a imagem e nome do produto
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('livewire.relatorios', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'averageTicket' => $averageTicket,
            'ordersByStatus' => $ordersByStatus,
            'topProducts' => $topProducts
        ]);
    }
}
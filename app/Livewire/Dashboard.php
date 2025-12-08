<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\Client;

class Dashboard extends Component
{
    public function render()
    {
        // 1. DADOS PRINCIPAIS (KPIs)
        $revenue = Order::whereIn('status', ['paid', 'shipped'])->sum('total_price');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $totalClients = Client::count();

        // 2. LISTAS OPERACIONAIS
        
        // Últimos 8 pedidos (para ter uma visão rápida do dia)
        $recentOrders = Order::with('client')
            ->latest()
            ->take(8)
            ->get();

        // Produtos com estoque BAIXO (Menor que 5 unidades)
        $lowStockProducts = Product::where('stock_quantity', '<', 5)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();

        // Últimos clientes cadastrados
        $latestClients = Client::latest()->take(4)->get();

        return view('livewire.dashboard', [
            'revenue' => $revenue,
            'pendingOrders' => $pendingOrders,
            'totalProducts' => $totalProducts,
            'totalClients' => $totalClients,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'latestClients' => $latestClients,
        ]);
    }
}
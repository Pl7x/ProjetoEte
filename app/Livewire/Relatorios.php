<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Relatorios extends Component
{
    public function render()
    {
        // 1. KPIs GERAIS (Vendas Reais)
        $vendasReais = Order::whereIn('status', ['paid', 'shipped']);
        
        $ticketMedio = (clone $vendasReais)->avg('total_price') ?? 0;
        $maiorVenda = (clone $vendasReais)->max('total_price') ?? 0;
        
        // --- CORREÇÃO DO ERRO ---
        // Adicionamos a contagem total de pedidos (independente do status)
        $totalOrders = Order::count(); 

        // 2. FINANCEIRO POR STATUS
        $financeiro = Order::select('status', DB::raw('sum(total_price) as total'), DB::raw('count(*) as qtd'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        // 3. TOP PRODUTOS
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereIn('orders.status', ['paid', 'shipped'])
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // 4. TOP CLIENTES
        $topClients = Client::withSum(['orders as total_spent' => function($query) {
                $query->whereIn('status', ['paid', 'shipped']);
            }], 'total_price')
            ->withCount(['orders' => function($query) {
                $query->whereIn('status', ['paid', 'shipped']);
            }])
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // 5. CATEGORIAS E ESTOQUE (Dados para o novo layout)
        $vendasPorCategoria = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereIn('orders.status', ['paid', 'shipped'])
            ->select('categories.name', DB::raw('SUM(order_items.price * order_items.quantity) as total'))
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        $valorEstoque = Product::sum(DB::raw('price * stock_quantity'));
        $totalProdutos = Product::count();
        
        // Total para cálculo de porcentagem
        $totalVendasGeral = (clone $vendasReais)->sum('total_price');

        return view('livewire.relatorios', [
            'ticketMedio' => $ticketMedio,
            'maiorVenda' => $maiorVenda,
            'totalOrders' => $totalOrders, // <--- AQUI ESTÁ A CORREÇÃO
            'financeiro' => $financeiro,
            'topProducts' => $topProducts,
            'topClients' => $topClients,
            'vendasPorCategoria' => $vendasPorCategoria,
            'valorEstoque' => $valorEstoque,
            'totalProdutos' => $totalProdutos,
            'totalVendasGeral' => $totalVendasGeral
        ]);
    }
}
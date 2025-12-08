<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\Client; // Mantido para o KPI total, mas removida a lista
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. DADOS PRINCIPAIS (KPIs)
        $revenue = Order::whereIn('status', ['paid', 'shipped'])->sum('total_price');
        
        // CORREÇÃO: "Pendentes" agora conta pedidos PAGOS que precisam de envio
        // Se quiseres ver aguardando pagamento e envio, usa: whereIn('status', ['pending', 'paid'])
        $pendingOrders = Order::where('status', 'paid')->count(); 
        
        $totalProducts = Product::count();
        $totalClients = Client::count();

        // 2. LISTAS OPERACIONAIS
        $recentOrders = Order::with('client')->latest()->take(8)->get();
        
        $lowStockProducts = Product::where('stock_quantity', '<', 5)
            ->orderBy('stock_quantity', 'asc')->take(5)->get();

        // (Removida a lista de $latestClients)

        // 3. DADOS DO GRÁFICO (Apenas Mensal)
        $dados = Order::whereIn('status', ['paid', 'shipped'])
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw("strftime('%m/%Y', created_at) as label"),
                DB::raw("strftime('%Y-%m', created_at) as sort_date"),
                DB::raw("SUM(total_price) as total")
            )
            ->groupBy('label', 'sort_date')
            ->orderBy('sort_date')
            ->get();

        $salesLabels = $dados->pluck('label');
        $salesValues = $dados->pluck('total');

        // 4. GRÁFICO DE STATUS
        $statusDistrib = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->get();
        
        $statusLabels = $statusDistrib->pluck('status')->map(fn($s) => match($s){
            'paid' => 'Pago (A enviar)', // Ajustado o texto para clareza
            'shipped' => 'Enviado', 
            'pending' => 'Pag. Pendente', 
            'failed' => 'Cancelado', 
            default => ucfirst($s)
        });
        $statusValues = $statusDistrib->pluck('total');

        return view('livewire.dashboard', [
            'revenue' => $revenue,
            'pendingOrders' => $pendingOrders,
            'totalProducts' => $totalProducts,
            'totalClients' => $totalClients,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'salesLabels' => $salesLabels,
            'salesValues' => $salesValues,
            'statusLabels' => $statusLabels,
            'statusValues' => $statusValues,
        ]);
    }
}
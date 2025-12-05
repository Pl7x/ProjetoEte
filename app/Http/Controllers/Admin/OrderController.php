<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index() {
        // Lista todos os pedidos
        $orders = Order::latest()->paginate(10);
        return view('admin.pedidos.index', compact('orders'));
    }

    public function show($id) {
        // Mostra um pedido específico com seus itens
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.pedidos.show', compact('order'));
    }
}
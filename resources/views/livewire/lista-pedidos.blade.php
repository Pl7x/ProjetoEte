<div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>N. Pedido</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name ?? 'Visitante' }}</td>
                        <td>
                            <span class="badge {{ $order->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ $order->status_formatado }}
                            </span>
                        </td>
                        <td>R$ {{ number_format($order->total_price, 2, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            {{-- Link para os detalhes (ajustaremos a rota depois se precisar) --}}
                            <a href="#" class="btn btn-sm btn-primary">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>
<div class="container-fluid px-4">
    
    {{-- Cards de Resumo --}}
    <div class="row g-4 mb-4">
        {{-- Faturamento --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-uppercase fw-bold text-muted mb-0">Faturamento Real</h6>
                        <i class="bi bi-cash-coin fs-4 text-success opacity-50"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-0">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</h2>
                    <small class="text-muted">Pedidos Pagos e Enviados</small>
                </div>
            </div>
        </div>

        {{-- Total de Pedidos --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-uppercase fw-bold text-muted mb-0">Total de Pedidos</h6>
                        <i class="bi bi-bag-check fs-4 text-primary opacity-50"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-0">{{ $totalOrders }}</h2>
                    <small class="text-muted">Todos os tempos</small>
                </div>
            </div>
        </div>

        {{-- Ticket Médio --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-uppercase fw-bold text-muted mb-0">Ticket Médio</h6>
                        <i class="bi bi-graph-up-arrow fs-4 text-info opacity-50"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-0">R$ {{ number_format($averageTicket, 2, ',', '.') }}</h2>
                    <small class="text-muted">Média por venda aprovada</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Coluna 1: Status dos Pedidos --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pie-chart me-2"></i>Pedidos por Status</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div><i class="bi bi-check-circle-fill text-success me-2"></i> Pagos</div>
                            <span class="badge bg-success rounded-pill px-3">{{ $ordersByStatus['paid'] ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div><i class="bi bi-truck text-info me-2"></i> Enviados</div>
                            <span class="badge bg-info text-dark rounded-pill px-3">{{ $ordersByStatus['shipped'] ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div><i class="bi bi-clock-history text-warning me-2"></i> Pendentes</div>
                            <span class="badge bg-warning text-dark rounded-pill px-3">{{ $ordersByStatus['pending'] ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div><i class="bi bi-x-circle-fill text-danger me-2"></i> Falhou/Cancelado</div>
                            <span class="badge bg-danger rounded-pill px-3">{{ $ordersByStatus['failed'] ?? 0 }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Coluna 2: Top Produtos --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-trophy me-2"></i>Top 5 Produtos Mais Vendidos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Produto</th>
                                    <th class="text-center">Qtd. Vendida</th>
                                    <th class="text-end pe-4">Receita Gerada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $item)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                {{-- Imagem do Produto --}}
                                                <div class="rounded border overflow-hidden me-3" style="width: 45px; height: 45px;">
                                                    @php
                                                        // Tratamento de imagem igual fizemos antes
                                                        $img = $item->product->image_data ?? null;
                                                        $src = asset('img/placeholder.png');
                                                        if ($img) {
                                                            if (str_starts_with($img, 'data:') || str_starts_with($img, 'http')) {
                                                                $src = $img;
                                                            } else {
                                                                $src = 'data:image/jpeg;base64,' . $img;
                                                            }
                                                        }
                                                    @endphp
                                                    <img src="{{ $src }}" class="w-100 h-100" style="object-fit: cover;">
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $item->product->name ?? 'Item removido' }}</div>
                                                    <small class="text-muted">Ref: {{ $item->product->id ?? '--' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold fs-5">{{ $item->total_qty }}</td>
                                        <td class="text-end pe-4 text-success fw-bold">
                                            R$ {{ number_format($item->total_revenue, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            Nenhum dado de venda encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
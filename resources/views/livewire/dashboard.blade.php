<div class="container-fluid px-2">
    
    {{-- CABEÇALHO E AÇÕES RÁPIDAS --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-0">Visão Geral</h3>
            <p class="text-muted mb-0">Bem-vindo ao painel administrativo.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('produtos.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi bi-plus-lg me-2"></i>Novo Produto
            </a>
            <a href="{{ route('pedidos') }}" class="btn btn-dark rounded-pill shadow-sm px-4">
                <i class="bi bi-list-check me-2"></i>Gerenciar Pedidos
            </a>
        </div>
    </div>

    {{-- CARDS DE STATUS (KPIs) --}}
    <div class="row g-4 mb-4">
        
        {{-- Card: Faturamento --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase fw-bold text-muted small mb-1">Receita Total</p>
                        <h3 class="fw-bold text-dark mb-0">R$ {{ number_format($revenue, 2, ',', '.') }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Pendentes (Com alerta visual se > 0) --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden {{ $pendingOrders > 0 ? 'border-start border-warning border-5' : '' }}">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase fw-bold text-muted small mb-1">Pedidos Pendentes</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $pendingOrders }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-exclamation-lg fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Clientes --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase fw-bold text-muted small mb-1">Clientes</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalClients }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Produtos --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase fw-bold text-muted small mb-1">Produtos Ativos</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalProducts }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        {{-- COLUNA PRINCIPAL: ÚLTIMOS PEDIDOS --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Pedidos Recentes</h6>
                    <a href="{{ route('pedidos') }}" class="btn btn-sm btn-light rounded-pill px-3">Ver Todos</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">#ID</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Total</th>
                                <th class="text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">#{{ $order->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2 text-muted fw-bold" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                {{ substr($order->client->name ?? $order->customer_name ?? 'V', 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="d-block fw-bold text-dark" style="font-size: 0.9rem;">
                                                    {{ $order->client->name ?? $order->customer_name ?? 'Visitante' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted small">{{ $order->created_at->format('d/m H:i') }}</td>
                                    <td class="fw-bold text-dark">R$ {{ number_format($order->total_price, 2, ',', '.') }}</td>
                                    <td class="text-end pe-4">
                                        @php
                                            $status = match($order->status) {
                                                'paid' => ['bg' => 'success', 'icon' => 'check-circle', 'text' => 'Pago'],
                                                'shipped' => ['bg' => 'info', 'icon' => 'truck', 'text' => 'Enviado'],
                                                'pending' => ['bg' => 'warning', 'icon' => 'clock', 'text' => 'Pendente'],
                                                'failed' => ['bg' => 'danger', 'icon' => 'x-circle', 'text' => 'Cancelado'],
                                                default => ['bg' => 'secondary', 'icon' => 'circle', 'text' => $order->status],
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $status['bg'] }} bg-opacity-10 text-{{ $status['bg'] }} rounded-pill px-3">
                                            <i class="bi bi-{{ $status['icon'] }} me-1"></i> {{ $status['text'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Nenhum pedido recente.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- COLUNA LATERAL --}}
        <div class="col-lg-4 d-flex flex-column gap-4">
            
            {{-- ALERTA DE ESTOQUE --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0 text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Estoque Baixo
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($lowStockProducts as $prod)
                            <li class="list-group-item px-4 py-3 border-0 d-flex align-items-center">
                                {{-- Imagem Mini --}}
                                <div class="rounded border overflow-hidden me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                    @php
                                        $img = $prod->image_data;
                                        $src = asset('img/placeholder.png');
                                        if($img) {
                                            $src = (str_starts_with($img, 'data:') || str_starts_with($img, 'http')) 
                                                    ? $img 
                                                    : 'data:image/jpeg;base64,' . $img;
                                        }
                                    @endphp
                                    <img src="{{ $src }}" class="w-100 h-100 object-fit-cover">
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 text-truncate small fw-bold text-dark">{{ $prod->name }}</h6>
                                </div>
                                <span class="badge bg-danger rounded-pill">{{ $prod->stock_quantity }} un</span>
                            </li>
                        @empty
                            <li class="list-group-item px-4 py-4 text-center text-muted small">
                                <i class="bi bi-check-circle-fill text-success me-1"></i> Estoque saudável!
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 text-center py-2">
                    <a href="{{ route('produtos') }}" class="small fw-bold text-decoration-none">Gerenciar Estoque</a>
                </div>
            </div>

            {{-- ÚLTIMOS CLIENTES --}}
            <div class="card border-0 shadow-sm rounded-4 flex-grow-1">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0 text-secondary">Novos Clientes</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($latestClients as $client)
                            <li class="list-group-item px-4 py-3 border-0 d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                    <i class="bi bi-person text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 small fw-bold text-dark">{{ $client->name }}</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        Cadastrado em {{ $client->created_at->format('d/m') }}
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container-fluid px-2">
    
    {{-- 1. CABEÇALHO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Relatório de Performance</h3>
            <p class="text-muted mb-0">Visão analítica de vendas, categorias e estoque.</p>
        </div>
        <button class="btn btn-outline-dark rounded-pill px-4 btn-sm" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Imprimir
        </button>
    </div>

    {{-- 2. BARRA DE INDICADORES CHAVE (Discreta, sem cara de dashboard) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
        <div class="card-body py-3 px-4">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Ticket Médio</small>
                    <div class="fw-bold text-dark">R$ {{ number_format($ticketMedio, 2, ',', '.') }}</div>
                </div>
                <div class="col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Maior Venda</small>
                    <div class="fw-bold text-success">R$ {{ number_format($maiorVenda, 2, ',', '.') }}</div>
                </div>
                <div class="col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Valor em Estoque</small>
                    <div class="fw-bold text-primary">R$ {{ number_format($valorEstoque, 2, ',', '.') }}</div>
                </div>
                <div class="col-md-3">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Produtos Cadastrados</small>
                    <div class="fw-bold text-dark">{{ $totalProdutos }} Produtos</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        {{-- 3. DESEMPENHO POR CATEGORIA (Gráfico de Barras Horizontal em HTML) --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0">Participação de Vendas por Categoria</h6>
                </div>
                <div class="card-body p-4 pt-2">
                    @forelse($vendasPorCategoria as $cat)
                        @php
                            $percent = ($totalVendasGeral > 0) ? ($cat->total / $totalVendasGeral) * 100 : 0;
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1 align-items-end">
                                <span class="fw-bold text-dark">{{ $cat->name }}</span>
                                <div class="text-end">
                                    <span class="fw-bold text-dark d-block">R$ {{ number_format($cat->total, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            {{-- Barra de progresso visual --}}
                            <div class="progress rounded-pill" style="height: 24px; background-color: #f0f2f5;">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $percent }}%; opacity: 0.8;">
                                    <span class="ps-2 text-white small fw-bold text-start w-100">{{ number_format($percent, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-bar-chart fs-1 d-block mb-2 opacity-25"></i>
                            Nenhuma venda categorizada ainda.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- 4. RESUMO FINANCEIRO (Tabela Compacta) --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0">Resumo Financeiro</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Status</th>
                                <th class="text-end">Qtd.</th>
                                <th class="text-end pe-4">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4"><span class="badge bg-success bg-opacity-10 text-success">Faturado</span></td>
                                <td class="text-end small">{{ ($financeiro['paid']->qtd ?? 0) + ($financeiro['shipped']->qtd ?? 0) }}</td>
                                <td class="text-end pe-4 fw-bold text-dark">
                                    R$ {{ number_format(($financeiro['paid']->total ?? 0) + ($financeiro['shipped']->total ?? 0), 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4"><span class="badge bg-warning bg-opacity-10 text-warning">Pendente</span></td>
                                <td class="text-end small">{{ $financeiro['pending']->qtd ?? 0 }}</td>
                                <td class="text-end pe-4 text-muted">
                                    R$ {{ number_format($financeiro['pending']->total ?? 0, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4"><span class="badge bg-danger bg-opacity-10 text-danger">Cancelado</span></td>
                                <td class="text-end small">{{ $financeiro['failed']->qtd ?? 0 }}</td>
                                <td class="text-end pe-4 text-muted">
                                    R$ {{ number_format($financeiro['failed']->total ?? 0, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="bg-light fw-bold">
                                <td class="ps-4">TOTAL GERAL</td>
                                <td class="text-end">{{ $totalOrders }}</td>
                                <td class="text-end pe-4">
                                    {{-- Soma de tudo --}}
                                    R$ {{ number_format(($financeiro['paid']->total ?? 0) + ($financeiro['shipped']->total ?? 0) + ($financeiro['pending']->total ?? 0) + ($financeiro['failed']->total ?? 0), 2, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    <div class="alert alert-light border mb-0 small text-muted">
                        <i class="bi bi-info-circle me-1"></i> 
                        O "Faturado" considera pedidos pagos e enviados. O "Total Geral" inclui intenções de compra não finalizadas.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. RANKINGS ESTRATÉGICOS --}}
    <div class="row g-4 mb-4">
        {{-- Clientes VIP --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Melhores Clientes (LTV)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-sm table-hover">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 py-2">Cliente</th>
                                <th class="text-center py-2">Pedidos</th>
                                <th class="text-end pe-4 py-2">Total Gasto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topClients as $client)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light text-secondary fw-bold d-flex align-items-center justify-content-center me-2 border" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                {{ substr($client->name, 0, 1) }}
                                            </div>
                                            <span class="text-dark small fw-bold">{{ $client->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted small">{{ $client->orders_count }}</td>
                                    <td class="text-end pe-4 fw-bold text-success small">
                                        R$ {{ number_format($client->total_spent, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-3 small text-muted">Sem dados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Produtos Rentáveis --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0">Produtos Mais Rentáveis</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($topProducts as $index => $prod)
                            <li class="list-group-item px-4 py-2 border-0 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <span class="text-muted me-2 small" style="width: 15px;">{{ $index + 1 }}.</span>
                                    <div class="d-flex flex-column" style="min-width: 0;">
                                        <span class="text-dark fw-bold small text-truncate" style="max-width: 200px;">{{ $prod->name }}</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="d-block text-primary fw-bold small">R$ {{ number_format($prod->total_revenue, 2, ',', '.') }}</span>
                                    <span class="text-muted" style="font-size: 0.7rem;">{{ $prod->total_qty }} un.</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-3 small">Sem dados.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
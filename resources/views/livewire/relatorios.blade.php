<div class="container-fluid px-2">
    
    {{-- 1. CABEÇALHO DO RELATÓRIO --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold text-dark mb-0">Relatório de Desempenho</h3>
            <p class="text-muted mb-0">Análise detalhada de vendas e comportamento.</p>
        </div>
        <div>
            <button class="btn btn-outline-secondary rounded-pill px-3" onclick="window.print()">
                <i class="bi bi-printer me-2"></i>Imprimir
            </button>
        </div>
    </div>

    {{-- 2. METRICAS ANALÍTICAS (Diferentes do Dashboard) --}}
    <div class="row g-4 mb-4">
        {{-- Card: Ticket Médio --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                            <i class="bi bi-bar-chart-line fs-4"></i>
                        </div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-0">Ticket Médio</h6>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">R$ {{ number_format($ticketMedio ?? 0, 2, ',', '.') }}</h2>
                    <p class="text-muted small mb-0">Média de valor por pedido realizado.</p>
                </div>
            </div>
        </div>

        {{-- Card: Maior Venda --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                            <i class="bi bi-trophy fs-4"></i>
                        </div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-0">Maior Venda Única</h6>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">R$ {{ number_format($maiorVenda ?? 0, 2, ',', '.') }}</h2>
                    <p class="text-muted small mb-0">O pedido de maior valor registrado.</p>
                </div>
            </div>
        </div>

        {{-- Card: Total de Itens Vendidos --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-2 me-3">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-0">Volume de Vendas</h6>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $totalItensVendidos ?? 0 }}</h2>
                    <p class="text-muted small mb-0">Total de unidades de produtos vendidas.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. GRÁFICO DE TENDÊNCIA E TOP PRODUTOS --}}
    <div class="row g-4 mb-4">
        
        {{-- Gráfico: Histórico Semestral (Analítico) --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0">Histórico de Faturamento (Últimos 6 Meses)</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 300px;">
                        <canvas id="historyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lista: Top 5 Produtos (Sucesso de Vendas) --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold mb-0">Top 5 Mais Vendidos</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush mt-2">
                        @forelse($topProducts as $index => $prod)
                            <li class="list-group-item px-4 py-3 border-0 d-flex align-items-center">
                                <div class="me-3 fw-bold text-muted fs-5" style="width: 20px;">#{{ $index + 1 }}</div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-dark fw-bold small">{{ $prod->name }}</h6>
                                    <small class="text-muted">Receita: R$ {{ number_format($prod->total_revenue, 2, ',', '.') }}</small>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                    {{ $prod->total_qty }} un
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-4">Sem dados de vendas.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. TABELA: TOP CLIENTES (VIPs) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h6 class="fw-bold mb-0">Clientes VIP (Maior Volume de Compras)</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Cliente</th>
                        <th>Pedidos Realizados</th>
                        <th>Última Compra</th>
                        <th class="text-end pe-4">Total Gasto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topClients as $client)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        {{ substr($client->name, 0, 1) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $client->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $client->orders_count }} pedidos</td>
                            <td class="text-muted small">{{ \Carbon\Carbon::parse($client->last_order_date)->format('d/m/Y') }}</td>
                            <td class="text-end pe-4 fw-bold text-success">
                                R$ {{ number_format($client->total_spent, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Nenhum dado encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 5. SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            
            // Gráfico de Histórico (Linha ou Barra Vertical)
            const ctxHistory = document.getElementById('historyChart');
            new Chart(ctxHistory, {
                type: 'line', // Linha mostra melhor a TENDÊNCIA ao longo do tempo
                data: {
                    labels: @json($chartLabels), // Ex: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']
                    datasets: [{
                        label: 'Faturamento Mensal',
                        data: @json($chartValues), // Ex: [1200, 1900, 3000, 2500...]
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        tension: 0.4, // Curva suave
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0d6efd',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#f0f0f0' },
                            ticks: { callback: (val) => 'R$ ' + val }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</div>
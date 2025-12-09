<div>
    <div wire:ignore.self class="modal fade" id="meusPedidosModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-4 shadow-lg h-100">
                
                <div class="modal-header border-bottom bg-white py-3 px-4">
                    <h5 class="modal-title fw-bold d-flex align-items-center">
                        <span class="bg-warning bg-opacity-25 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="bi bi-bag-heart-fill"></i>
                        </span>
                        Meus Pedidos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4 bg-light">
                    
                    @forelse ($orders as $order)
                        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase ls-1">Pedido #{{ $order->id }}</span>
                                    <div class="small text-muted">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                
                                @php
                                    $statusColor = match($order->status) {
                                        'paid' => 'success',
                                        'shipped' => 'primary',
                                        'pending' => 'warning',
                                        'failed' => 'danger',
                                        default => 'secondary'
                                    };
                                    $statusLabel = match($order->status) {
                                        'paid' => 'Pagamento Aprovado',
                                        'shipped' => 'Enviado / A Caminho',
                                        'pending' => 'Aguardando Pagamento',
                                        'failed' => 'Cancelado',
                                        default => $order->status
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-3 py-2 rounded-pill border border-{{ $statusColor }} border-opacity-25">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="px-4 mt-3 mb-2">
                                <div class="progress" style="height: 6px; border-radius: 10px;">
                                    @php
                                        $progress = match($order->status) {
                                            'pending' => 25,
                                            'paid' => 50,
                                            'shipped' => 100,
                                            default => 0
                                        };
                                        $barColor = $order->status == 'failed' ? 'bg-danger' : 'bg-success';
                                    @endphp
                                    <div class="progress-bar {{ $barColor }}" role="progressbar" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="vstack gap-3">
                                    @foreach ($order->items as $item)
                                        <div class="d-flex align-items-center bg-light p-2 rounded-3 border border-light">
                                            <div class="flex-shrink-0 bg-white rounded-3 overflow-hidden border shadow-sm" style="width: 60px; height: 60px;">
                                                @if($item->product && $item->product->image_data)
                                                    <img src="{{ $item->product->image_data }}" class="w-100 h-100 object-fit-cover">
                                                @else
                                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 200px;">
                                                    {{ $item->product->name ?? 'Produto Indisponível' }}
                                                </h6>
                                                <small class="text-muted">{{ $item->quantity }} unidade(s)</small>
                                            </div>
                                            
                                            <div class="text-end fw-bold text-dark ms-2">
                                                R$ {{ number_format($item->price, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center">
                                @if($order->status === 'shipped')
                                    <small class="text-primary fw-bold">
                                        <i class="bi bi-truck me-1"></i> Enviado em {{ $order->shipped_at ? $order->shipped_at->format('d/m/Y') : '--/--' }}
                                    </small>
                                @else
                                    <span></span> {{-- Espaçador --}}
                                @endif

                                <div class="text-end">
                                    <span class="text-muted small text-uppercase">Total do Pedido</span>
                                    <div class="fs-5 fw-bold text-dark lh-1">R$ {{ number_format($order->total_price, 2, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-4 position-relative d-inline-block">
                                <div class="bg-white rounded-circle shadow-sm p-4 d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                    <i class="bi bi-basket2 text-muted opacity-25" style="font-size: 3.5rem;"></i>
                                </div>
                                <span class="position-absolute top-0 end-0 bg-warning p-2 rounded-circle border border-4 border-light"></span>
                            </div>
                            <h4 class="fw-bold text-dark">Nenhum pedido por aqui</h4>
                            <p class="text-muted mb-4 px-5">Que tal explorar nossa loja e encontrar algo incrível hoje?</p>
                            <button class="btn btn-dark rounded-pill px-5 py-2 fw-bold" data-bs-dismiss="modal">
                                Ir para a Loja
                            </button>
                        </div>
                    @endforelse

                </div>
                <div class="modal-footer border-top-0 bg-white">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
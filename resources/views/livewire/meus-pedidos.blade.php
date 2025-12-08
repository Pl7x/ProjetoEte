<div class="container py-5">
    
    {{-- Cabeçalho da Página --}}
    <div class="d-flex flex-column align-items-center mb-5">
        <h2 class="fw-bold display-6 text-dark">Meus Pedidos</h2>
        <p class="text-muted">Acompanhe suas compras e status de entrega</p>
    </div>

    {{-- LISTAGEM (GRID DE CARDS) --}}
    <div class="row g-4">
        @forelse($orders as $order)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover transition-all">
                    
                    {{-- Cabeçalho do Card --}}
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge bg-light text-dark border rounded-pill px-3 mb-2">
                                #{{ $order->id }}
                            </span>
                            <div class="small text-muted">{{ $order->created_at->format('d/m/Y') }}</div>
                        </div>
                        
                        {{-- Status Badge --}}
                        @php
                            $statusConfig = match($order->status) {
                                'shipped' => ['bg' => 'success', 'icon' => 'truck', 'text' => 'Enviado'],
                                'paid'    => ['bg' => 'primary', 'icon' => 'bag-check', 'text' => 'Pago'],
                                'pending' => ['bg' => 'warning', 'icon' => 'clock', 'text' => 'Pendente'],
                                'failed'  => ['bg' => 'danger',  'icon' => 'x-circle', 'text' => 'Cancelado'],
                                default   => ['bg' => 'secondary', 'icon' => 'circle', 'text' => $order->status],
                            };
                        @endphp
                        <div class="d-flex flex-column align-items-end">
                            <span class="badge bg-{{ $statusConfig['bg'] }} bg-opacity-10 text-{{ $statusConfig['bg'] }} rounded-pill px-3 py-2 d-flex align-items-center gap-1">
                                <i class="bi bi-{{ $statusConfig['icon'] }}"></i> {{ $statusConfig['text'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Corpo: Galeria de Imagens --}}
                    <div class="card-body px-4 py-3">
                        <p class="text-muted small fw-bold text-uppercase mb-2">Itens do pedido</p>
                        
                        <div class="d-flex gap-2">
                            {{-- Loop para mostrar as imagens --}}
                            @foreach($order->items->take(3) as $item)
                                @php
                                    // --- LÓGICA DE CORREÇÃO DE IMAGEM ---
                                    $rawImage = $item->product->image_data ?? null; // Usa image_data conforme seu Model
                                    $imageSrc = asset('img/placeholder.png'); // Imagem padrão se falhar

                                    if ($rawImage) {
                                        if (str_starts_with($rawImage, 'data:') || str_starts_with($rawImage, 'http')) {
                                            $imageSrc = $rawImage;
                                        } else {
                                            // Se for Base64 puro sem cabeçalho, adiciona
                                            $imageSrc = 'data:image/jpeg;base64,' . $rawImage;
                                        }
                                    }
                                @endphp

                                <div class="position-relative border rounded-3 overflow-hidden" style="width: 60px; height: 60px;">
                                    <img src="{{ $imageSrc }}" 
                                         class="w-100 h-100 object-fit-cover" 
                                         alt="Produto"
                                         onerror="this.src='https://via.placeholder.com/60?text=Erro'">
                                </div>
                            @endforeach

                            {{-- Contador se tiver mais itens --}}
                            @if($order->items->count() > 3)
                                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted fw-bold small" 
                                     style="width: 60px; height: 60px;">
                                    +{{ $order->items->count() - 3 }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Rodapé do Card --}}
                    <div class="card-footer bg-white border-0 px-4 pb-4 pt-0 d-flex justify-content-between align-items-end">
                        <div>
                            <small class="text-muted d-block">Total</small>
                            <span class="fs-5 fw-bold text-dark">R$ {{ number_format($order->total_price, 2, ',', '.') }}</span>
                        </div>
                        <button wire:click="selectOrder({{ $order->id }})" 
                                data-bs-toggle="modal" 
                                data-bs-target="#orderModal"
                                class="btn btn-outline-dark rounded-pill px-4 stretched-link">
                            Detalhes
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                    <i class="bi bi-basket3 fs-1 text-muted"></i>
                </div>
                <h4 class="fw-bold text-secondary">Nenhum pedido encontrado</h4>
                <a href="{{ route('catalogo') }}" class="btn btn-primary rounded-pill mt-3 px-4 shadow-sm">
                    Ir às Compras
                </a>
            </div>
        @endforelse
    </div>

    {{-- Paginação --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>

    {{-- 
        =========================================
        MODAL DE DETALHES (COM IMAGENS CORRIGIDAS)
        =========================================
    --}}
    <div wire:ignore.self class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                
                @if($selectedOrder)
                    <div class="modal-header border-0 bg-light px-4 py-3">
                        <div>
                            <h5 class="modal-title fw-bold">Pedido #{{ $selectedOrder->id }}</h5>
                            <span class="text-muted small">Realizado em {{ $selectedOrder->created_at->format('d/m/Y \à\s H:i') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-0">
                        <div class="row g-0">
                            
                            {{-- Lado Esquerdo: Lista de Produtos --}}
                            <div class="col-md-7 p-4 bg-white" style="max-height: 500px; overflow-y: auto;">
                                <h6 class="fw-bold text-uppercase text-muted mb-4 small">Produtos Comprados</h6>
                                
                                <div class="d-flex flex-column gap-3">
                                    @foreach($selectedOrder->items as $item)
                                        @php
                                            // --- LÓGICA DE CORREÇÃO DE IMAGEM (Repetida para o Modal) ---
                                            $rawImage = $item->product->image_data ?? null;
                                            $imageSrc = asset('img/placeholder.png');

                                            if ($rawImage) {
                                                if (str_starts_with($rawImage, 'data:') || str_starts_with($rawImage, 'http')) {
                                                    $imageSrc = $rawImage;
                                                } else {
                                                    $imageSrc = 'data:image/jpeg;base64,' . $rawImage;
                                                }
                                            }
                                        @endphp

                                        <div class="d-flex align-items-center">
                                            {{-- Imagem do Produto no Modal --}}
                                            <div class="rounded-3 overflow-hidden border flex-shrink-0" style="width: 70px; height: 70px;">
                                                <img src="{{ $imageSrc }}" 
                                                     class="w-100 h-100 object-fit-cover" 
                                                     alt="{{ $item->product->name ?? 'Produto' }}"
                                                     onerror="this.src='https://via.placeholder.com/70?text=Erro'">
                                            </div>

                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="mb-1 fw-bold text-dark text-truncate" style="max-width: 200px;">
                                                    {{ $item->product->name ?? 'Produto Indisponível' }}
                                                </h6>
                                                <div class="text-muted small">
                                                    {{ $item->quantity }}x <span class="ms-1">R$ {{ number_format($item->price, 2, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="fw-bold text-dark">
                                                R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="border-top mt-4 pt-3 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-secondary">Total do Pedido</span>
                                    <span class="fs-4 fw-bold text-success">
                                        R$ {{ number_format($selectedOrder->total_price, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Lado Direito: Status e Info --}}
                            <div class="col-md-5 bg-light p-4 border-start">
                                
                                {{-- Card de Status --}}
                                <div class="bg-white p-3 rounded-3 shadow-sm border mb-4 text-center">
                                    @if($selectedOrder->status == 'shipped')
                                        <div class="text-success mb-2"><i class="bi bi-truck fs-1"></i></div>
                                        <h5 class="fw-bold text-success">Pedido Enviado!</h5>
                                        @if($selectedOrder->shipped_at)
                                            <small class="text-muted d-block">
                                                Data: {{ $selectedOrder->shipped_at->format('d/m/Y') }}<br>
                                                Hora: {{ $selectedOrder->shipped_at->format('H:i') }}
                                            </small>
                                        @endif
                                    @elseif($selectedOrder->status == 'paid')
                                        <div class="text-primary mb-2"><i class="bi bi-box-seam fs-1"></i></div>
                                        <h5 class="fw-bold text-primary">Preparando Envio</h5>
                                        <small class="text-muted">Seu pagamento foi aprovado.</small>
                                    @else
                                        <div class="text-secondary mb-2"><i class="bi bi-hourglass-split fs-1"></i></div>
                                        <h5 class="fw-bold text-secondary">{{ ucfirst($selectedOrder->status) }}</h5>
                                    @endif
                                </div>

                                {{-- Endereço --}}
                                <h6 class="fw-bold text-uppercase text-muted mb-3 small">
                                    <i class="bi bi-geo-alt me-1"></i> Entrega
                                </h6>
                                @php
                                    $addr = $selectedOrder->shipping_address ?? [];
                                    $user = Auth::guard('client')->user();
                                    $rua = $addr['address'] ?? $user->endereco ?? '---';
                                    $num = $addr['number'] ?? $user->numero ?? '';
                                    $cidade = $addr['city'] ?? $user->cidade ?? '';
                                    $estado = $addr['state'] ?? $user->estado ?? '';
                                    $cep = $addr['zip_code'] ?? $user->cep ?? '';
                                @endphp
                                <p class="mb-0 bg-white p-3 rounded-3 border text-secondary small">
                                    <strong class="text-dark d-block mb-1">{{ $rua }}, {{ $num }}</strong>
                                    {{ $cidade }} - {{ $estado }}<br>
                                    CEP: {{ $cep }}
                                </p>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    {{-- Estilo Extra --}}
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        .object-fit-cover {
            object-fit: cover;
        }
    </style>
</div>
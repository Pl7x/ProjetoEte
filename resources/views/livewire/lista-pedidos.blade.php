<div>
    {{-- Tabela de Pedidos --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
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
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer_name ?? 'Visitante' }}</td>
                        <td>
                            @php
                                $statusClass = match($order->status) {
                                    'paid' => 'bg-success',
                                    'shipped' => 'bg-info text-dark',
                                    'pending' => 'bg-warning text-dark',
                                    'failed' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                                
                                $statusLabel = match($order->status) {
                                    'paid' => 'Pago',
                                    'shipped' => 'Enviado',
                                    'pending' => 'Pendente',
                                    'failed' => 'Falhou',
                                    default => $order->status,
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td>R$ {{ number_format($order->total_price, 2, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <button wire:click="selectOrder({{ $order->id }})" 
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#orderDetailsModal">
                                <i class="bi bi-eye"></i> Detalhes
                            </button>
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

    {{-- MODAL DE DETALHES DO PEDIDO --}}
    <div wire:ignore.self class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">
                        @if($selectedOrder)
                            Pedido #{{ $selectedOrder->id }} - Detalhes
                        @else
                            Carregando...
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div wire:loading wire:target="selectOrder" class="w-100 text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Buscando informações...</p>
                    </div>

                    @if($selectedOrder)
                        <div wire:loading.remove wire:target="selectOrder">
                            
                            @php
                                // --- LÓGICA DE DADOS E FORMATAÇÃO ---
                                $address = $selectedOrder->shipping_address ?? null;
                                $cliente = $selectedOrder->client;
                                
                                $rua = $address['address'] ?? $cliente->endereco ?? 'Endereço não encontrado';
                                $num = $address['number'] ?? $cliente->numero ?? 'S/N';
                                $bairro = $address['district'] ?? $cliente->bairro ?? '';
                                $cidade = $address['city'] ?? $cliente->cidade ?? '';
                                $estado = $address['state'] ?? $cliente->estado ?? '';
                                
                                $rawCep = $address['zip_code'] ?? $cliente->cep ?? '';
                                $rawCpf = $cliente->cpf ?? '';
                                $rawPhone = $cliente->phone ?? '';

                                // Closure para formatação
                                $fmt = function($v, $type) {
                                    $v = preg_replace('/\D/', '', $v);
                                    if (empty($v)) return 'Não informado';

                                    return match($type) {
                                        'cpf' => preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $v),
                                        'cep' => preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $v),
                                        'phone' => strlen($v) === 11 
                                            ? preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", $v)
                                            : preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2-\$3", $v),
                                        default => $v,
                                    };
                                };
                            @endphp

                            {{-- Seção 1: Dados do Cliente e Endereço --}}
                            <div class="row g-4 mb-4">
                                {{-- Coluna Cliente --}}
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-uppercase text-muted mb-3">
                                                <i class="bi bi-person-circle me-1"></i> Dados do Cliente
                                            </h6>
                                            @if($selectedOrder->client)
                                                <p class="mb-1"><strong>Nome:</strong> {{ $selectedOrder->client->name }}</p>
                                                <p class="mb-1"><strong>CPF:</strong> {{ $fmt($rawCpf, 'cpf') }}</p>
                                                <p class="mb-1"><strong>Tel:</strong> {{ $fmt($rawPhone, 'phone') }}</p>
                                                <p class="mb-0"><strong>Email:</strong> {{ $selectedOrder->client->email }}</p>
                                            @else
                                                <p class="mb-1"><strong>Nome:</strong> {{ $selectedOrder->customer_name ?? 'Visitante' }}</p>
                                                <p class="text-muted fst-italic">Cliente não cadastrado (Compra como visitante).</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Coluna Endereço --}}
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-uppercase text-muted mb-3">
                                                <i class="bi bi-geo-alt-fill me-1"></i> Endereço de Entrega
                                            </h6>
                                            <p class="mb-1">{{ $rua }}, {{ $num }}</p>
                                            <p class="mb-1">{{ $bairro }}</p>
                                            <p class="mb-1">{{ $cidade }} - {{ $estado }}</p>
                                            <p class="mb-0"><strong>CEP:</strong> {{ $fmt($rawCep, 'cep') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Seção 2: Lista de Produtos --}}
                            <h6 class="fw-bold text-uppercase text-muted mb-3">
                                <i class="bi bi-box-seam me-1"></i> Itens do Pedido
                            </h6>
                            <div class="table-responsive border rounded mb-3">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Imagem</th> {{-- Nova Coluna --}}
                                            <th>Produto</th>
                                            <th class="text-center">Qtd</th>
                                            <th class="text-end">Preço Unit.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($selectedOrder->items as $item)
                                            @php
                                                // --- LÓGICA DE IMAGEM ---
                                                // Verifica image_data (pode ser URL, Base64 ou path)
                                                $rawImage = $item->product->image_data ?? null;
                                                $imageSrc = asset('img/placeholder.png'); // Placeholder padrão

                                                if ($rawImage) {
                                                    if (str_starts_with($rawImage, 'data:') || str_starts_with($rawImage, 'http')) {
                                                        // Se já for base64 completo ou URL externa
                                                        $imageSrc = $rawImage;
                                                    } else {
                                                        // Se for apenas o hash do base64 (comum se salvo via upload simples sem prefixo)
                                                        // Ou se for caminho local, tente asset('storage/...') caso use storage link
                                                        // Assumindo padrão do projeto anterior (Base64):
                                                        $imageSrc = 'data:image/jpeg;base64,' . $rawImage;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                {{-- Célula da Imagem --}}
                                                <td>
                                                    <div class="border rounded overflow-hidden d-flex align-items-center justify-content-center bg-white" 
                                                         style="width: 50px; height: 50px;">
                                                        <img src="{{ $imageSrc }}" 
                                                             alt="Produto"
                                                             class="w-100 h-100"
                                                             style="object-fit: cover;"
                                                             onerror="this.src='https://via.placeholder.com/50?text=S/IMG'">
                                                    </div>
                                                </td>
                                                <td>{{ $item->product->name ?? 'Produto Indisponível' }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-end">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                                <td class="text-end fw-bold">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold text-uppercase">Total do Pedido:</td>
                                            <td class="text-end fw-bold fs-5 text-success">
                                                R$ {{ number_format($selectedOrder->total_price, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    @endif
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    
                    @if($selectedOrder && $selectedOrder->status != 'shipped')
                        <button wire:click="markAsShipped" 
                                wire:loading.attr="disabled"
                                class="btn btn-success fw-bold">
                            <i class="bi bi-truck me-1"></i> Confirmar Envio
                        </button>
                    @endif

                    @if($selectedOrder && $selectedOrder->status == 'shipped')
                        <button disabled class="btn btn-outline-success opacity-75">
                            <i class="bi bi-check-circle-fill me-1"></i> Pedido Enviado
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
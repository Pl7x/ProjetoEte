<div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel" wire:ignore.self>
        <div class="offcanvas-header bg-warning">
            <h5 class="offcanvas-title fw-bold text-dark" id="cartOffcanvasLabel">
                <i class="bi bi-cart3 me-2"></i> Meu Carrinho
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body d-flex flex-column p-0">
            
            @if(Auth::guard('client')->check())

                @if(count($cart) > 0)
                    <div class="flex-grow-1 overflow-auto p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            {{-- CORREÇÃO: Texto corrigido --}}
                            <span class="small text-muted fw-bold">Selecione para comprar</span>
                            <span class="badge bg-secondary">{{ count($selectedItems) }} selecionados</span>
                        </div>

                        @foreach($cart as $id => $item)
                            @php
                                // 1. Tenta pegar a imagem do array principal ou dos atributos
                                // Como mudou o nome no banco para 'image_data', verificamos esse nome também
                                $rawImage = $item['image_data'] 
                                            ?? $item['attributes']['image_data'] 
                                            ?? $item['image'] 
                                            ?? $item['attributes']['image'] 
                                            ?? null;

                                // 2. Lógica inteligente para Base64
                                $imageSrc = 'https://via.placeholder.com/60?text=Sem+Img'; // Padrão

                                if ($rawImage) {
                                    // Se o texto já começar com "data:image", é um Base64 pronto
                                    if (str_starts_with($rawImage, 'data:image')) {
                                        $imageSrc = $rawImage;
                                    } 
                                    // Se for Base64 puro sem cabeçalho, adicionamos o cabeçalho
                                    elseif (base64_decode($rawImage, true) !== false) {
                                        $imageSrc = 'data:image/jpeg;base64,' . $rawImage;
                                    }
                                    // Se não for base64, assume que é caminho antigo (retrocompatibilidade)
                                    else {
                                        $imageSrc = asset('storage/' . $rawImage);
                                    }
                                }
                            @endphp

                            <div class="card mb-3 border-0 shadow-sm {{ in_array($id, $selectedItems) ? 'border-start border-4 border-warning' : 'opacity-75' }}">
                                <div class="row g-0 align-items-center">
                                    <div class="col-1 d-flex justify-content-center">
                                        <div class="form-check">
                                            <input class="form-check-input border-secondary" 
                                                   type="checkbox" 
                                                   value="{{ $id }}" 
                                                   wire:model.live="selectedItems"
                                                   style="transform: scale(1.3); cursor: pointer;">
                                        </div>
                                    </div>
                                    <div class="col-3 p-2">
                                        {{-- Exibe a imagem processada --}}
                                        <img src="{{ $imageSrc }}" 
                                             class="img-fluid rounded" 
                                             style="object-fit: contain; height: 60px; width: 100%;"
                                             alt="{{ $item['name'] }}">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h6 class="card-title mb-1 text-truncate fw-bold" style="max-width: 130px;">{{ $item['name'] }}</h6>
                                                <button wire:click="remove({{ $id }})" class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            <p class="card-text text-muted small mb-2">R$ {{ number_format($item['price'], 2, ',', '.') }}</p>
                                            
                                            <div class="d-flex align-items-center">
                                                <div class="input-group input-group-sm" style="width: 100px;">
                                                    <button wire:click="decrement({{ $id }})" class="btn btn-outline-secondary" type="button" @if(!in_array($id, $selectedItems)) disabled @endif>-</button>
                                                    <input type="text" class="form-control text-center bg-white" value="{{ $item['quantity'] }}" readonly>
                                                    <button wire:click="increment({{ $id }})" class="btn btn-outline-secondary" type="button" @if(!in_array($id, $selectedItems)) disabled @endif>+</button>
                                                </div>
                                                <div class="ms-auto fw-bold small text-success">
                                                    R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

 <div class="border-top p-3 bg-light mt-auto shadow-lg">
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <span class="h6 mb-0 text-muted">Total ({{ count($selectedItems) }} itens):</span>
        <span class="h4 fw-bold text-dark mb-0">R$ {{ number_format($total, 2, ',', '.') }}</span>
    </div>
    
    <div class="d-grid gap-2">
        <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
            @csrf @foreach($selectedItems as $selectedId)
                <input type="hidden" name="selected_items[]" value="{{ $selectedId }}">
            @endforeach

            <button type="submit" 
                    class="btn btn-dark btn-lg fw-bold w-100" 
                    @if($total <= 0) disabled @endif>
                Finalizar Compra <i class="bi bi-credit-card-2-front ms-2"></i>
            </button>
        </form>

        <button class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Continuar Comprando</button>
    </div>
</div>
                @else
                    <div class="text-center my-auto p-4">
                        <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                        <h5 class="text-muted fw-bold mt-3">Carrinho vazio</h5>
                        
                        <a href="{{ route('catalogo') }}" class="btn btn-warning fw-bold mt-2 rounded-pill">
                            Ver Produtos
                        </a>
                    </div>
                @endif

            @else
                <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center p-4 text-center bg-light">
                    <div class="bg-white p-4 rounded-circle shadow-sm mb-4">
                        <i class="bi bi-lock-fill text-warning display-3"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Acesso Restrito</h4>
                    <p class="text-muted mb-4">Faça login para gerenciar seu carrinho.</p>
                    <button wire:click="$dispatch('open-auth-modal')" class="btn btn-dark btn-lg w-100 fw-bold shadow-sm" data-bs-dismiss="offcanvas">
                        Fazer Login
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
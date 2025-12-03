<div> {{-- RAIZ ÚNICA --}}
    
    @if($product)
        @php
            // Cálculos
            $isOverStock = $quantity > $product->stock_quantity;
            $isInvalidQuantity = $quantity < 1;
            $hasNoStock = $product->stock_quantity <= 0;
            $totalPrice = $product->price * (is_numeric($quantity) ? $quantity : 0);
        @endphp

        {{-- 
            BOTÃO DE FECHAR (CORRIGIDO) 
            - position-absolute: Fica flutuando sobre o conteúdo
            - top-0 end-0: Canto superior direito
            - z-3: Garante que fique ACIMA de tudo (clicável sempre)
        --}}
        <button type="button" 
                class="btn-close position-absolute top-0 end-0 m-4 z-3" 
                data-bs-dismiss="modal" 
                aria-label="Close"></button>
        
        {{-- Adicionei 'mt-3' para dar um respiro no topo por causa do botão --}}
        <div class="modal-body p-4 mt-2">
            <div class="row g-4 align-items-center">
                
                {{-- Coluna da Imagem --}}
                <div class="col-md-6">
                    <div class="bg-light rounded-4 p-3 d-flex justify-content-center align-items-center" style="height: 350px;">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}"
                                 class="img-fluid rounded-3 shadow-sm hover-scale transition-transform"
                                 style="max-height: 300px; object-fit: contain; mix-blend-mode: multiply;"
                                 alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x400?text=Sem+Imagem" class="img-fluid rounded-3" alt="Sem imagem">
                        @endif
                    </div>
                </div>

                {{-- Coluna dos Detalhes --}}
                <div class="col-md-6">
                    <small class="text-uppercase text-muted fw-bold">{{ $product->category->name ?? 'Geral' }}</small>
                    <h3 class="fw-bold mb-3 pe-4">{{-- pe-4 para o texto não ficar embaixo do botão fechar em telas menores --}}
                        {{ $product->name }}
                    </h3>
                    
                    <p class="text-muted mb-4" style="max-height: 100px; overflow-y: auto;">
                        {{ $product->description }}
                    </p>

                    {{-- PREÇO DINÂMICO --}}
                    <div class="mb-4 bg-light p-3 rounded-3">
                         <h2 class="fw-bold text-dark mb-0">
                            R$ {{ number_format($totalPrice, 2, ',', '.') }}
                         </h2>
                         @if($quantity > 1 && !$isInvalidQuantity)
                            <small class="text-muted">
                                ({{ $quantity }}x R$ {{ number_format($product->price, 2, ',', '.') }}/un)
                            </small>
                         @endif
                    </div>

                    {{-- SELETOR DE QUANTIDADE --}}
                    <div class="d-flex flex-column gap-2 mb-4">
                        <label class="small fw-bold {{ $isOverStock ? 'text-danger' : 'text-muted' }}">
                            Quantidade:
                        </label>

                        <div class="d-flex align-items-center gap-3">
                            <div class="input-group" style="width: 180px;">
                                <button class="btn btn-outline-secondary border-light-subtle bg-light"
                                        type="button"
                                        wire:click="decrement"
                                        @if($quantity <= 1) disabled @endif>
                                    <i class="bi bi-dash"></i>
                                </button>

                                <input type="number"
                                       min="1"
                                       max="{{ $product->stock_quantity }}"
                                       class="form-control text-center bg-light border-light-subtle fw-bold no-spinners"
                                       wire:model.blur="quantity" 
                                       @if($hasNoStock) disabled @endif>

                                <button class="btn btn-outline-secondary border-light-subtle bg-light"
                                        type="button"
                                        wire:click="increment"
                                        @if($quantity >= $product->stock_quantity) disabled @endif>
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            
                            <span class="small transition-all {{ $isOverStock ? 'text-danger fw-bold' : 'text-muted' }}">
                                @if($hasNoStock)
                                    <span class="badge bg-danger">Esgotado</span>
                                @else
                                    ({{ $product->stock_quantity }} disponíveis)
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- BOTÕES DE AÇÃO --}}
                    <div class="d-grid gap-2">
                        <button wire:click="addToCart" 
                                class="btn btn-dark rounded-pill fw-bold py-3 px-4 shadow-sm"
                                @if($isInvalidQuantity || $hasNoStock) disabled @endif>
                            
                            <span wire:loading.remove wire:target="addToCart">
                                <i class="bi bi-cart-plus me-2"></i> Adicionar ao Carrinho
                            </span>
                            <span wire:loading wire:target="addToCart">
                                <span class="spinner-border spinner-border-sm me-2"></span> Processando...
                            </span>
                        </button>
                    </div>
                    
                    @if(!Auth::guard('client')->check())
                        <div class="text-center mt-2">
                            <small class="text-muted fst-italic" style="font-size: 0.75rem;">
                                <i class="bi bi-info-circle"></i> Faça login para finalizar a compra.
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="modal-body py-5 text-center">
             <div class="spinner-border text-warning mb-3" role="status"></div>
             <p class="fw-bold text-muted">Carregando o produto...</p>
        </div>
    @endif

    <style>
        .no-spinners::-webkit-outer-spin-button,
        .no-spinners::-webkit-inner-spin-button {
            -webkit-appearance: none; margin: 0;
        }
        .no-spinners { -moz-appearance: textfield; }
        .transition-all { transition: all 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
    </style>
</div>
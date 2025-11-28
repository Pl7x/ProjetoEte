<div>
    {{-- Só mostra o conteúdo se o produto tiver sido carregado --}}
    @if($product)
        {{-- Verifica se a quantidade atual excede o estoque --}}
        @php
            $isOverStock = $quantity > $product->stock_quantity;
            $isInvalidQuantity = $quantity < 1 || $isOverStock;
            $hasNoStock = $product->stock_quantity <= 0;
        @endphp

        <div class="modal-header border-2 pb-12">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0 pb-4 px-4">
            <div class="row g-4 align-items-center">
                {{-- Coluna da Imagem (sem alterações) --}}
                <div class="col-md-6">
                    <div class="bg-light rounded-4 p-3 d-flex justify-content-center align-items-center" style="height: 350px;">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}"
                                 class="img-fluid rounded-3 shadow-sm"
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
                    <h3 class="fw-bold mb-3">{{ $product->name }}</h3>
                    <p class="text-muted mb-4">{{ $product->description }}</p>

                    {{-- MUDANÇA 1: Preço Dinâmico --}}
                    <div class="mb-4 bg-light p-3 rounded-3">
                         {{-- Exibe o preço total calculado no PHP --}}
                         <h2 class="fw-bold text-dark mb-0">
                            R$ {{ number_format($this->totalPrice, 2, ',', '.') }}
                         </h2>
                         {{-- Se a quantidade for maior que 1, mostra o cálculo unitário para clareza --}}
                         @if($quantity > 1 && !$isInvalidQuantity)
                            <small class="text-muted">
                                ({{ $quantity }}x R$ {{ number_format($product->price, 2, ',', '.') }}/un)
                            </small>
                         @endif
                    </div>

                                            {{-- Seletor de Quantidade Visual --}}
                        <div class="d-flex flex-column gap-2 mb-4">
                            <label class="small fw-bold {{ $isOverStock ? 'text-danger' : 'text-muted' }}">
                                Quantidade:
                            </label>

                            <div class="d-flex align-items-center gap-3">
                                {{-- MUDANÇA AQUI: Aumentei a largura de 140px para 180px --}}
                                <div class="input-group" style="width: 180px;">
                                    <button class="btn btn-outline-secondary border-light-subtle bg-light"
                                            type="button"
                                            wire:click="decrement"
                                            @if($quantity <= 1) disabled @endif>
                                        <i class="bi bi-dash"></i>
                                    </button>

                                    {{-- O input já usa a classe is-invalid do Bootstrap automaticamente graças ao @error --}}
                                    <input type="number"
                                        min="1"
                                        {{-- Removemos o max="" do HTML para permitir que o usuário digite e veja o erro --}}
                                        class="form-control text-center bg-light border-light-subtle fw-bold no-spinners @error('quantity') is-invalid @enderror"
                                        wire:model.live.debounce.500ms="quantity"
                                        @if($hasNoStock) disabled @endif>

                                    <button class="btn btn-outline-secondary border-light-subtle bg-light"
                                            type="button"
                                            wire:click="increment"
                                            {{-- Desabilita se já estiver no limite ou acima dele --}}
                                            @if($quantity >= $product->stock_quantity) disabled @endif>
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                {{-- MUDANÇA 3: Texto do estoque fica vermelho e em negrito se excedido --}}
                                <span class="small transition-all {{ $isOverStock ? 'text-danger fw-bold' : 'text-muted' }}">
                                    @if($hasNoStock)
                                        <span class="badge bg-danger">Esgotado</span>
                                    @else
                                        ({{ $product->stock_quantity }} disponíveis)
                                    @endif
                                </span>
                            </div>

                            {{-- Mensagem de erro de validação --}}
                            @error('quantity')
                                <div class="text-danger small fw-bold animate-bounce">
                                    <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                    {{-- Botões de Ação --}}
                    <div class="d-flex gap-2 flex-column flex-sm-row">
                        {{-- MUDANÇA 4: Desabilita os botões se a quantidade for inválida ou não tiver estoque --}}
                        <button class="btn btn-primary rounded-pill fw-bold py-2 px-4 flex-grow-1"
                                @if($isInvalidQuantity || $hasNoStock) disabled @endif>
                           <i class="bi bi-bag-check me-2"></i> Comprar Agora
                        </button>
                        <button class="btn btn-dark rounded-pill fw-bold py-2 px-4 flex-grow-1"
                                @if($isInvalidQuantity || $hasNoStock) disabled @endif>
                           <i class="bi bi-cart-plus me-2"></i> Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Loading State --}}
        <div class="modal-body py-5 text-center">
             <div class="spinner-border text-primary mb-3" role="status"></div>
             <p class="fw-bold text-muted">Carregando produto...</p>
        </div>
    @endif

    {{-- Pequeno estilo CSS para remover as setinhas padrão do input number --}}
    <style>
        .no-spinners::-webkit-outer-spin-button,
        .no-spinners::-webkit-inner-spin-button {
            -webkit-appearance: none; margin: 0;
        }
        .no-spinners { -moz-appearance: textfield; }
        /* Transição suave para a cor do texto */
        .transition-all { transition: all 0.3s ease; }
    </style>
</div>
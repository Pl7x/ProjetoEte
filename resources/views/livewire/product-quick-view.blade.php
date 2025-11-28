<div>
    {{-- Só mostra o conteúdo se o produto tiver sido carregado --}}
    @if($product)
        <div class="modal-header border-1 pb-10">
            {{--
                 MUDANÇA AQUI: O Botão Fechar (X).
                 O atributo 'data-bs-dismiss="modal"' é o segredo do Bootstrap para fechar a modal.
                 Certifique-se de que ele está exatamente assim.
            --}}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0 pb-4 px-4">
            <div class="row g-4 align-items-center">
                {{-- Coluna da Imagem --}}
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

                    <div class="mb-4">
                         <h2 class="fw-bold text-dark">R$ {{ number_format($product->price, 2, ',', '.') }}</h2>
                    </div>

                    {{-- Seletor de Quantidade Visual --}}
                    <div class="d-flex flex-column gap-2 mb-4">
                        <label class="small fw-bold text-muted">Quantidade:</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="input-group" style="width: 140px;">
                                {{-- Desabilita o botão '-' se a quantidade for 1 --}}
                                <button class="btn btn-outline-secondary border-light-subtle bg-light"
                                        type="button"
                                        wire:click="decrement"
                                        @if($quantity <= 1) disabled @endif>
                                    <i class="bi bi-dash"></i>
                                </button>

                                {{--
                                     Input de quantidade:
                                     - max: define o limite máximo no HTML com base no estoque.
                                     - wire:model.live.debounce.500ms: sincroniza com o Livewire após 500ms.
                                     - is-invalid: adiciona classe de erro do Bootstrap se houver erro de validação.
                                --}}
                                <input type="number"
                                       min="1"
                                       max="{{ $product->stock_quantity }}"
                                       class="form-control text-center bg-light border-light-subtle fw-bold no-spinners @error('quantity') is-invalid @enderror"
                                       wire:model.live.debounce.500ms="quantity">

                                {{-- Desabilita o botão '+' se a quantidade for igual ou maior que o estoque --}}
                                <button class="btn btn-outline-secondary border-light-subtle bg-light"
                                        type="button"
                                        wire:click="increment"
                                        @if($quantity >= $product->stock_quantity) disabled @endif>
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            {{-- Mostra o estoque disponível --}}
                            <span class="small text-muted">({{ $product->stock_quantity }} disponíveis)</span>
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
                        <button class="btn btn-primary rounded-pill fw-bold py-2 px-4 flex-grow-1">
                           <i class="bi bi-bag-check me-2"></i> Comprar Agora
                        </button>
                        <button class="btn btn-dark rounded-pill fw-bold py-2 px-4 flex-grow-1">
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
            -webkit-appearance: none;
            margin: 0;
        }
        .no-spinners {
            -moz-appearance: textfield;
        }
    </style>
</div>
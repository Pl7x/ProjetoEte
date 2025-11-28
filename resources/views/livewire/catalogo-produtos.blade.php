<div class="container py-5">

    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Catálogo de Produtos</h1>
        <p class="text-muted lead">Encontre o suplemento ideal para o seu treino.</p>
    </div>

    <div class="row g-5">

        {{-- Sidebar de Filtros --}}
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px;">

                {{-- Botão Mobile --}}
                <button class="btn btn-outline-dark w-100 d-lg-none mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
                    <i class="bi bi-funnel me-2"></i> Filtros
                </button>

                <div class="collapse d-lg-block" id="filtersCollapse">

                    {{-- Filtro: Busca --}}
                    <div class="mb-4 position-relative">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="form-control rounded-pill ps-4 bg-light border-0"
                               placeholder="Buscar produto...">
                        <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>

                    {{-- Filtro: Categorias --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-dark mb-3">Categorias</h6>
                        <div class="list-group list-group-flush small">
                            <button wire:click="$set('categoryFilter', null)"
                                    class="list-group-item list-group-item-action border-0 px-0 py-2 bg-transparent {{ is_null($categoryFilter) ? 'fw-bold text-dark' : 'text-muted' }}">
                                Todos
                            </button>
                            @foreach($categories as $cat)
                                <button wire:click="$set('categoryFilter', '{{ $cat->id }}')"
                                        class="list-group-item list-group-item-action border-0 px-0 py-2 bg-transparent {{ $categoryFilter == $cat->id ? 'fw-bold text-dark' : 'text-muted' }}">
                                    {{ $cat->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <hr class="opacity-10 my-4">

                    {{-- Filtro: Preço --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-dark mb-3">Preço</h6>
                        <div class="d-flex gap-2">
                            <input type="number" min="0" step="0.01" wire:model.live.debounce.500ms="minPrice" class="form-control form-control-sm" placeholder="Min">
                            <input type="number" min="0" step="0.01" wire:model.live.debounce.500ms="maxPrice" class="form-control form-control-sm" placeholder="Max">
                        </div>
                    </div>

                    <hr class="opacity-10 my-4">

                    {{-- Loading Indicator --}}
                    <div wire:loading class="text-center w-100 py-2">
                        <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                        <small class="text-muted ms-2">Atualizando...</small>
                    </div>

                    {{-- Botão Limpar Filtros --}}
                    <button wire:click="resetFilters" class="btn btn-sm btn-outline-secondary w-100 mt-3">
                        Limpar Filtros
                    </button>
                </div>
            </div>
        </div>

        {{-- Grid de Produtos --}}
        <div class="col-lg-9">

            {{-- Toolbar Superior --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <p class="text-muted small mb-2 mb-md-0">
                    Mostrando <strong>{{ count($products) }}</strong> produtos
                </p>
                <div class="d-flex align-items-center">
                    <label class="small text-muted me-2 text-nowrap">Ordenar por:</label>
                    <select wire:model.live="sort" class="form-select form-select-sm border-0 bg-light fw-bold" style="width: 160px;">
                        <option value="relevancia">Relevância</option>
                        <option value="price_asc">Menor Preço</option>
                        <option value="price_desc">Maior Preço</option>
                    </select>
                </div>
            </div>

            {{-- Lista de Cards --}}
            <div class="row g-4">
                @forelse($products as $produto)
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden group" wire:key="product-{{ $produto->id }}">
                            <div class="position-relative bg-light p-4 mb-3 rounded-3 d-flex align-items-center justify-content-center" style="height: 250px;">
                                @if ($produto->image_path)
                                    <img src="{{ asset('storage/' . $produto->image_path) }}"
                                         class="img-fluid transition-transform group-hover-scale"
                                         style="mix-blend-mode: multiply; max-height: 180px;"
                                         alt="{{ $produto->name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x300?text=Sem+Imagem" class="img-fluid transition-transform group-hover-scale" style="mix-blend-mode: multiply; max-height: 180px;" alt="Imagem não disponível">
                                @endif

                                {{-- Botão Comprar (ALTERADO PARA ABRIR A MODAL) --}}
                                <button wire:click.prevent="openQuickView({{ $produto->id }})"
                                        class="btn btn-dark w-75 position-absolute bottom-0 mb-3 rounded-pill shadow fw-bold opacity-0 group-hover-visible translate-y-100 group-hover-translate-0 transition-all">
                                    <span wire:loading.remove wire:target="openQuickView({{ $produto->id }})">Comprar</span>
                                    <span wire:loading wire:target="openQuickView({{ $produto->id }})">
                                        <span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span> Carregando...
                                    </span>
                                </button>
                            </div>

                            <div class="card-body pt-0 px-3 pb-4 text-center">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">{{ $produto->category->name ?? 'Sem Categoria' }}</small>
                                <h6 class="fw-bold text-dark mt-1 mb-2 text-truncate">{{ $produto->name }}</h6>

                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <h5 class="fw-bold mb-0 text-dark">R$ {{ number_format($produto->price, 2, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-search display-1 text-muted opacity-25"></i>
                        </div>
                        <h4 class="text-muted">Nenhum produto encontrado.</h4>
                        <p class="text-muted small">Tente ajustar os filtros ou buscar por outro termo.</p>
                        <button wire:click="resetFilters" class="btn btn-warning fw-bold mt-2">Limpar Filtros</button>
                    </div>
                @endforelse
            </div>
             {{-- Paginação --}}
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- --- MODAL QUICK VIEW (ADICIONADA AQUI) --- --}}
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                @if($selectedProductId)
    @livewire('product-quick-view', ['productId' => $selectedProductId], key('quick-view-' . $selectedProductId))
        @else
    @endif
            </div>
        </div>
    </div>
    {{-- ------------------------------------------- --}}

    {{-- Estilos Inline (Mantidos) --}}
    <style>
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }

        .group:hover .group-hover-visible { opacity: 1 !important; }
        .group:hover .group-hover-scale { transform: scale(1.08); }
        .group:hover .group-hover-translate-0 { transform: translateY(0) !important; }

        .transition-all { transition: all 0.3s ease; }
        .transition-transform { transition: transform 0.4s ease; }
        .translate-y-100 { transform: translateY(100%); }
    </style>

    {{-- Script para abrir a modal (Adicionado aqui) --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            const modalElement = document.getElementById('quickViewModal');
            const modalInstance = new bootstrap.Modal(modalElement);

            // Ouve o evento disparado pelo componente do catálogo para abrir a modal
            Livewire.on('show-quick-view-modal', () => {
                modalInstance.show();
            });

            // Opcional: Limpa o ID do produto selecionado quando a modal fecha
            modalElement.addEventListener('hidden.bs.modal', () => {
                // Chama um método no componente Livewire para resetar o ID (se necessário)
                // @this.call('closeQuickView');
            });
        });
    </script>
</div>
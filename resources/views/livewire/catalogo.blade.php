<div class="container py-5">

    {{-- Toast de Notificação (Feedback ao adicionar ao carrinho) --}}
    {{-- Utiliza AlpineJS para escutar o evento disparado pelo componente Livewire --}}
    <div x-data="{ show: false, message: '' }"
         x-on:produto-adicionado.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
         class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div x-show="show" x-transition class="toast show align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i> <span x-text="message"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="show = false"></button>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Catálogo de Produtos</h1>
        <p class="text-muted lead">Encontre o suplemento ideal para o seu treino.</p>
    </div>

    <div class="row g-5">

        {{-- Sidebar de Filtros --}}
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px;">

                {{-- Botão Mobile para expandir filtros --}}
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
                            <button wire:click="$set('categoria', null)"
                                    class="list-group-item list-group-item-action border-0 px-0 py-2 bg-transparent {{ is_null($categoria) ? 'fw-bold text-dark' : 'text-muted' }}">
                                Todos
                            </button>
                            @foreach(['Proteínas', 'Creatinas', 'Pré-Treinos', 'Vitaminas'] as $cat)
                                <button wire:click="$set('categoria', '{{ $cat }}')"
                                        class="list-group-item list-group-item-action border-0 px-0 py-2 bg-transparent {{ $categoria === $cat ? 'fw-bold text-dark' : 'text-muted' }}">
                                    {{ $cat }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <hr class="opacity-10 my-4">

                    {{-- Filtro: Preço --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-dark mb-3">Preço</h6>
                        <div class="d-flex gap-2">
                            <input type="number" wire:model.live.debounce.500ms="minPrice" class="form-control form-control-sm" placeholder="Min">
                            <input type="number" wire:model.live.debounce.500ms="maxPrice" class="form-control form-control-sm" placeholder="Max">
                        </div>
                    </div>

                    <hr class="opacity-10 my-4">

                    {{-- Filtro: Marcas --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-dark mb-3">Marcas</h6>
                        @foreach(['SuppStore Nutrition', 'Max Titanium', 'Integralmédica', 'Dux Nutrition'] as $brand)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" wire:model.live="selectedBrands" value="{{ $brand }}" id="brand-{{ $loop->index }}">
                                <label class="form-check-label small text-muted" for="brand-{{ $loop->index }}">{{ $brand }}</label>
                            </div>
                        @endforeach
                    </div>

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
                    Mostrando <strong>{{ count($produtos) }}</strong> produtos
                </p>
                <div class="d-flex align-items-center">
                    <label class="small text-muted me-2 text-nowrap">Ordenar por:</label>
                    <select wire:model.live="sort" class="form-select form-select-sm border-0 bg-light fw-bold" style="width: 150px;">
                        <option value="relevancia">Relevância</option>
                        <option value="price_asc">Menor Preço</option>
                        <option value="price_desc">Maior Preço</option>
                        <option value="newest">Mais Recentes</option>
                    </select>
                </div>
            </div>

            {{-- Lista de Cards --}}
            <div class="row g-4">
                @forelse($produtos as $produto)
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden group">
                            <div class="position-relative bg-light p-4 mb-3 rounded-3 d-flex align-items-center justify-content-center" style="height: 250px;">
                                @if(isset($produto['desconto']) && $produto['desconto'])
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 fw-bold">-{{ $produto['desconto'] }}%</span>
                                @endif

                                <img src="{{ $produto['imagem'] }}"
                                     class="img-fluid transition-transform group-hover-scale"
                                     style="mix-blend-mode: multiply; max-height: 180px;"
                                     alt="{{ $produto['nome'] }}">

                                {{-- Botão Comprar (Aparece no Hover) --}}
                                <button wire:click="addToCart({{ $produto['id'] }})"
                                        class="btn btn-dark w-75 position-absolute bottom-0 mb-3 rounded-pill shadow fw-bold opacity-0 group-hover-visible translate-y-100 group-hover-translate-0 transition-all">
                                    <span wire:loading.remove wire:target="addToCart({{ $produto['id'] }})">Comprar</span>
                                    <span wire:loading wire:target="addToCart({{ $produto['id'] }})"><i class="bi bi-hourglass-split"></i></span>
                                </button>
                            </div>

                            <div class="card-body pt-0 px-3 pb-4 text-center">
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">{{ $produto['categoria'] }}</small>
                                <h6 class="fw-bold text-dark mt-1 mb-2 text-truncate">{{ $produto['nome'] }}</h6>
                                <p class="small text-muted mb-2">{{ $produto['marca'] }}</p>

                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    @if(isset($produto['preco_antigo']) && $produto['preco_antigo'])
                                        <span class="text-muted text-decoration-line-through small">R$ {{ number_format($produto['preco_antigo'], 2, ',', '.') }}</span>
                                    @endif
                                    <h5 class="fw-bold mb-0 text-dark">R$ {{ number_format($produto['preco'], 2, ',', '.') }}</h5>
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
        </div>
    </div>

    {{-- Estilos Inline para Efeitos --}}
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
</div>


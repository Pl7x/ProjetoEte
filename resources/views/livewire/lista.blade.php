<div class="container-fluid px-0">

    {{-- Cabeçalho com botão Novo --}}
    <div class="d-flex justify-content-between align-items-center my-4">
        <h4 class="mb-0">Gerenciar Lista</h4>
        <a href="{{ route('produtos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Novo Produto
        </a>
    </div>

    {{-- BARRA DE FILTROS --}}
    <div class="card mb-4 border-0 shadow-sm bg-light">
        <div class="card-body py-3">
            <div class="row g-3">
                {{-- Pesquisa por Nome --}}
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Buscar por nome do produto..." 
                            wire:model.live.debounce.300ms="search">
                    </div>
                </div>

                {{-- Filtro por Categoria --}}
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-filter"></i></span>
                        <select class="form-select border-start-0 ps-0" wire:model.live="category_id">
                            <option value="">Todas as Categorias</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mensagens de Sucesso/Erro --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Cartão da Tabela --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-list me-1 text-primary"></i>
                Lista de Itens
            </div>
            @if($search || $category_id)
                <small class="text-muted fw-normal">
                    Encontrados: {{ $produtos->total() }} produtos
                </small>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Imagem</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold">Nome</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold">Categoria</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold">Preço</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold text-center">Estoque</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold" style="min-width: 200px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($produtos as $produto)
                        <tr>
                            <td class="ps-4 py-3">
                                {{-- LÓGICA DE IMAGEM ATUALIZADA (Base64) --}}
                                <div class="rounded border d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 50px; height: 50px; overflow:hidden;">
                                    @if($produto->image_data)
                                        {{-- Exibe a imagem salva no banco (funciona para Base64 e URLs antigas) --}}
                                        <img src="{{ $produto->image_data }}" alt="{{ $produto->name }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        {{-- Sem Imagem --}}
                                        <span class="text-muted small"><i class="fas fa-image fa-lg"></i></span>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-bold text-dark">{{ $produto->name }}</td>
                            <td>
                                @if($produto->category)
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-normal px-3 py-2 rounded-pill">
                                        {{ $produto->category->name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary fw-normal px-3 py-2 rounded-pill">Sem Categoria</span>
                                @endif
                            </td>
                            <td class="fw-bold text-success">
                                R$ {{ number_format($produto->price, 2, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if($produto->stock_quantity <= 0)
                                    <span class="badge bg-danger bg-opacity-10 text-danger fw-normal px-3 py-2 rounded-pill">Esgotado</span>
                                @elseif($produto->stock_quantity <= 10)
                                    <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-2 rounded-pill">{{ $produto->stock_quantity }} unid. (Baixo)</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success fw-normal px-3 py-2 rounded-pill">{{ $produto->stock_quantity }} unidades</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('produtos.edit', ['product' => $produto->id]) }}" class="btn btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger"
                                        wire:click="confirmDelete({{ $produto->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="confirmDelete({{ $produto->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-search fa-3x mb-3 text-secondary opacity-25"></i>
                                    <p class="mb-1 fs-5 fw-bold">Nenhum produto encontrado.</p>
                                    <p class="small mb-3">
                                        @if($search || $category_id)
                                            Tente ajustar os filtros de busca.
                                        @else
                                            O banco de dados está vazio.
                                        @endif
                                    </p>
                                    @if(!$search && !$category_id)
                                        <a href="{{ route('produtos.create') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-1"></i> Cadastrar o primeiro produto
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($produtos->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3 border-top-0">
            {{ $produtos->links() }}
        </div>
        @endif
    </div>

    {{-- Modal de Exclusão --}}
    <div wire:ignore.self class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($productToDeleteName)
                        <p>Tem certeza que deseja excluir o produto <strong>{{ $productToDeleteName }}</strong>?</p>
                    @else
                        <p>Tem certeza que deseja excluir este produto?</p>
                    @endif
                    <p class="text-danger small mb-0">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteProduct" wire:loading.attr="disabled">
                        <span wire:loading wire:target="deleteProduct" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Confirmar Exclusão
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-delete-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
                myModal.show();
            });

            Livewire.on('hide-delete-modal', () => {
                var el = document.getElementById('deleteProductModal');
                var myModal = bootstrap.Modal.getInstance(el);
                if (myModal) {
                    myModal.hide();
                }
            });
        });
    </script>
    @endpush
</div>
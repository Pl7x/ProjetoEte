<div class="row g-4">
    {{-- Coluna Principal do Formulário --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                <h5 class="m-0 fw-bold text-primary"><i class="bi bi-file-earmark-text me-2"></i>Informações do Produto</h5>
            </div>
            <div class="card-body p-4">
            <div> {{-- Adicione uma div raiz para envolver tudo --}}

    {{-- Mensagens de Sucesso/Erro (DENTRO DO COMPONENTE LIVEWIRE) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 border-start border-5 border-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" wire:click="$set('success', null)"></button> {{-- Adicione wire:click para fechar --}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4 border-0 border-start border-5 border-danger d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- ... resto do seu formulário (col-lg-8 e col-lg-4) ... --}}
        <div class="col-lg-8">
           {{-- ... --}}
        </div>
        <div class="col-lg-4">
           {{-- ... --}}
        </div>
    </div>

</div> {{-- Fim da div raiz --}}
                <form wire:submit.prevent="updateProduct" class="row g-3" id="form-edicao-produto">

                    {{-- Nome do Produto --}}
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold text-secondary">Nome do Produto*</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" id="name" wire:model.live="name" placeholder="Ex: Creatina Monohidratada" required>
                        </div>
                        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    {{-- Categoria e Preço --}}
                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold text-secondary">Categoria*</label>
                         <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-bookmarks"></i></span>
                            <select class="form-select border-start-0 ps-0 @error('category_id') is-invalid @enderror" id="category_id" wire:model="category_id" required>
                                <option value="">Selecione...</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold text-secondary">Preço*</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">R$</span>
                            <input type="number" step="0.01" class="form-control border-start-0 ps-0 @error('price') is-invalid @enderror" id="price" wire:model="price" placeholder="0,00" required>
                        </div>
                        @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    {{-- Estoque --}}
                    <div class="col-md-6">
                        <label for="stock_quantity" class="form-label fw-semibold text-secondary">Estoque*</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-box-seam"></i></span>
                            <input type="number" class="form-control border-start-0 ps-0 @error('stock_quantity') is-invalid @enderror" id="stock_quantity" wire:model="stock_quantity" placeholder="Quantidade" required>
                        </div>
                        @error('stock_quantity') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    {{-- Descrição --}}
                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold text-secondary">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description" rows="4" placeholder="Detalhes do produto..."></textarea>
                        @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    {{-- Botão de Salvar (AGORA AQUI NA ESQUERDA) --}}
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-5 d-flex align-items-center justify-content-center shadow-sm" wire:loading.attr="disabled">
                            <span wire:loading class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            <i class="bi bi-check2-circle me-2 fs-4" wire:loading.remove></i> Salvar Alterações
                        </button>
                        <p class="text-center text-muted small mt-3 mb-0"><i class="bi bi-shield-check me-1"></i> Suas alterações serão salvas com segurança.</p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Coluna Lateral da Imagem e Dicas (SEM O BOTÃO) --}}
    <div class="col-lg-4">
        {{-- Card de Mídia --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                 <h5 class="m-0 fw-bold text-primary"><i class="bi bi-image me-2"></i>Mídia</h5>
            </div>
            <div class="card-body p-4 text-center">
                {{-- Área de Pré-visualização da Imagem --}}
                <div class="mb-4 position-relative">
                    @if ($new_image)
                        <img src="{{ $new_image->temporaryUrl() }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; width: 100%; object-fit: contain; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                        <div wire:loading wire:target="new_image" class="position-absolute top-50 start-50 translate-middle">
                             <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Carregando...</span></div>
                        </div>
                    @elseif ($existing_image_path)
                        @if(Str::startsWith($existing_image_path, 'http'))
                             <img src="{{ $existing_image_path }}" alt="Imagem Atual" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; width: 100%; object-fit: contain; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                        @else
                             <img src="{{ asset('storage/' . $existing_image_path) }}" alt="Imagem Atual" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; width: 100%; object-fit: contain; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                        @endif
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-3 bg-light text-secondary fw-bold" style="height: 250px; border: 2px dashed #dee2e6;">
                            <div class="text-center">
                                <i class="bi bi-image display-4 mb-2 opacity-50"></i>
                                <p class="mb-0">Sem imagem</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Input de Arquivo --}}
                <div class="mb-3">
                    <label for="new_image" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center cursor-pointer">
                        <i class="bi bi-cloud-arrow-up me-2"></i> {{ $new_image ? 'Trocar Imagem' : ($existing_image_path ? 'Substituir Imagem' : 'Adicionar Imagem') }}
                    </label>
                    <input type="file" class="d-none" id="new_image" wire:model="new_image" accept="image/png, image/jpeg, image/jpg, image/webp">
                    @error('new_image') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>
                <p class="text-muted small mb-0">Formatos: PNG, JPG, WEBP. Max: 1MB.</p>
            </div>
        </div>

        {{-- Card de Dicas de Edição --}}
        <div class="card shadow-sm border-0 mb-4 bg-light">
            <div class="card-header bg-transparent py-3 d-flex align-items-center border-bottom-0">
                 <h6 class="m-0 fw-bold text-secondary"><i class="bi bi-info-circle me-2"></i>Dicas de Edição</h6>
            </div>
            <div class="card-body p-4 pt-0 text-muted small">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-check2-circle me-2 text-success fs-6 mt-1"></i>
                        <span>O nome do produto é único e não pode ser igual a outro já existente para evitar duplicações.</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-check2-circle me-2 text-success fs-6 mt-1"></i>
                        <span>Mantenha a descrição clara e objetiva. Detalhes técnicos e benefícios ajudam na decisão de compra.</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="bi bi-check2-circle me-2 text-success fs-6 mt-1"></i>
                        <span>Imagens de alta qualidade e com boa iluminação valorizam o produto e aumentam as vendas.</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- O card com o botão de salvar que estava aqui foi removido --}}

    </div>
</div>
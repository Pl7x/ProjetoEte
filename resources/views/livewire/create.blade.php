<div> {{-- Div raiz do componente Livewire --}}

    {{-- Mensagens de Sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 border-start border-5 border-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" wire:click="$set('success', null)"></button>
        </div>
    @endif

    {{-- Formulário Principal --}}
    {{-- CORREÇÃO: O método no seu Create.php chama-se 'saveProduct' --}}
    <form wire:submit.prevent="saveProduct"> 
        
        <div class="row g-4">
            
            {{-- ==============================
                 COLUNA PRINCIPAL (Dados)
            ================================ --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                        <h5 class="m-0 fw-bold text-primary">
                            <i class="bi bi-plus-circle me-2"></i>Cadastrar Novo Produto
                        </h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- Nome do Produto --}}
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-semibold text-secondary">Nome do Produto*</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" id="name" wire:model.live="name" placeholder="Ex: Creatina Monohidratada" required>
                                </div>
                                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Categoria --}}
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

                            {{-- Preço --}}
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
                                    <input type="number" class="form-control border-start-0 ps-0 @error('stock_quantity') is-invalid @enderror" id="stock_quantity" wire:model="stock_quantity" placeholder="Quantidade inicial" required>
                                </div>
                                @error('stock_quantity') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Descrição --}}
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold text-secondary">Descrição</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description" rows="4" placeholder="Detalhes técnicos e benefícios do produto..."></textarea>
                                @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Botão de Salvar --}}
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-5 d-flex align-items-center justify-content-center shadow-sm" wire:loading.attr="disabled">
                                    <span wire:loading class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    <i class="bi bi-check-lg me-2 fs-4" wire:loading.remove></i> Cadastrar Produto
                                </button>
                                <p class="text-center text-muted small mt-3 mb-0">
                                    <i class="bi bi-shield-check me-1"></i> As informações serão salvas no catálogo.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- ==============================
                 COLUNA LATERAL (Imagem e Dicas)
            ================================ --}}
            <div class="col-lg-4">
                
                {{-- Card de Mídia --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                         <h5 class="m-0 fw-bold text-primary"><i class="bi bi-image me-2"></i>Mídia</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        
                        {{-- Área de Pré-visualização da Imagem --}}
                        <div class="mb-4 position-relative">
                            {{-- CORREÇÃO: Usando a variável $image definida no Create.php --}}
                            @if ($image) 
                                <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; width: 100%; object-fit: contain; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                                <div wire:loading wire:target="image" class="position-absolute top-50 start-50 translate-middle">
                                     <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Carregando...</span></div>
                                </div>
                            @else
                                {{-- Placeholder padrão para novo produto --}}
                                <div class="d-flex align-items-center justify-content-center rounded-3 bg-light text-secondary fw-bold" style="height: 250px; border: 2px dashed #dee2e6;">
                                    <div class="text-center">
                                        <i class="bi bi-cloud-upload display-4 mb-2 opacity-50"></i>
                                        <p class="mb-0">Fazer Upload</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Input de Arquivo --}}
                        <div class="mb-3">
                            {{-- CORREÇÃO: labels e inputs apontando para 'image' --}}
                            <label for="image" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center cursor-pointer">
                                <i class="bi bi-cloud-arrow-up me-2"></i> {{ $image ? 'Trocar Imagem' : 'Selecionar Imagem' }}
                            </label>
                            <input type="file" class="d-none" id="image" wire:model="image" accept="image/png, image/jpeg, image/jpg, image/webp">
                            @error('image') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                        <p class="text-muted small mb-0">Formatos: PNG, JPG, WEBP. Max: 1MB.</p>
                    </div>
                </div>

                {{-- Card de Dicas --}}
                <div class="card shadow-sm border-0 mb-4 bg-light">
                    <div class="card-header bg-transparent py-3 d-flex align-items-center border-bottom-0">
                         <h6 class="m-0 fw-bold text-secondary"><i class="bi bi-lightbulb me-2"></i>Dicas de Cadastro</h6>
                    </div>
                    <div class="card-body p-4 pt-0 text-muted small">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle me-2 text-success fs-6 mt-1"></i>
                                <span>Verifique se o nome do produto está correto e sem erros de digitação.</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-check2-circle me-2 text-success fs-6 mt-1"></i>
                                <span>Preencha a quantidade inicial de estoque corretamente.</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bi bi-check2-circle me-2 text-success fs-6 mt-1"></i>
                                <span>Use uma imagem quadrada ou retangular com boa resolução.</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div> {{-- Fim da Coluna Lateral --}}
        </div> {{-- Fim da Row --}}
    </form>
</div>
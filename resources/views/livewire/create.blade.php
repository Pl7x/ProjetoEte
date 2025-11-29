<div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 border-start border-5 border-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" wire:click="$set('success', null)"></button>
        </div>
    @endif

    <form wire:submit.prevent="saveProduct">
        <div class="row g-4">
            {{-- Coluna Principal --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                        <h5 class="m-0 fw-bold text-primary">
                            {{-- TÍTULO DINÂMICO --}}
                            @if($product)
                                <i class="bi bi-pencil-square me-2"></i>Editar Produto
                            @else
                                <i class="bi bi-plus-circle me-2"></i>Cadastrar Novo Produto
                            @endif
                        </h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Campos (Nome, Categoria, etc...) --}}
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-semibold text-secondary">Nome do Produto*</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" id="name" wire:model.live="name" required>
                                </div>
                                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

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
                                    <input type="number" step="0.01" class="form-control border-start-0 ps-0 @error('price') is-invalid @enderror" id="price" wire:model="price" required>
                                </div>
                                @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="stock_quantity" class="form-label fw-semibold text-secondary">Estoque*</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-box-seam"></i></span>
                                    <input type="number" class="form-control border-start-0 ps-0 @error('stock_quantity') is-invalid @enderror" id="stock_quantity" wire:model="stock_quantity" required>
                                </div>
                                @error('stock_quantity') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold text-secondary">Descrição</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description" rows="4"></textarea>
                            </div>

                            {{-- BOTÃO DINÂMICO --}}
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-5 d-flex align-items-center justify-content-center shadow-sm" wire:loading.attr="disabled">
                                    <span wire:loading class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    @if($product)
                                        <i class="bi bi-check2-square me-2 fs-4" wire:loading.remove></i> Salvar Alterações
                                    @else
                                        <i class="bi bi-check-lg me-2 fs-4" wire:loading.remove></i> Cadastrar Produto
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Coluna Lateral (Imagem) --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                         <h5 class="m-0 fw-bold text-primary"><i class="bi bi-image me-2"></i>Mídia</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-4 position-relative">
                            {{-- Lógica de Preview: Nova Imagem > Imagem Existente > Placeholder --}}
                            @if ($image) 
                                <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px;">
                            @elseif($existing_image)
                                <img src="{{ asset('storage/' . $existing_image) }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px;">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded-3 bg-light text-secondary fw-bold" style="height: 250px; border: 2px dashed #dee2e6;">
                                    <div class="text-center">
                                        <i class="bi bi-cloud-upload display-4 mb-2 opacity-50"></i>
                                        <p class="mb-0">Sem imagem</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="image" class="btn btn-outline-primary w-100 cursor-pointer">
                                <i class="bi bi-cloud-arrow-up me-2"></i> {{ $image || $existing_image ? 'Alterar Imagem' : 'Selecionar Imagem' }}
                            </label>
                            <input type="file" class="d-none" id="image" wire:model="image" accept="image/*">
                            @error('image') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
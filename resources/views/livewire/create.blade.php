<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h2 class="mt-4">Novo Produto</h2>
        <a href="{{ route('produtos') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Voltar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Atenção!</strong> Verifique os erros abaixo.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Preencha os dados
        </div>
        <div class="card-body">
            <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    {{-- Nome (name) --}}
                    <div class="col-md-8">
                        <label for="name" class="form-label fw-bold">Nome do Produto*</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Categoria --}}
                    <div class="col-md-4">
                        <label for="category_id" class="form-label fw-bold">Categoria*</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option selected disabled value="">Selecione...</option>
                            @foreach($categorias as $categoria)
                                {{-- Nota: Aqui usamos $categoria->name (inglês) --}}
                                <option value="{{ $categoria->id }}" {{ old('category_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->name }}
                                </option>
                            @endforeach
                        </select>
                         @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Preço (price) --}}
                    <div class="col-md-4">
                        <label for="price" class="form-label fw-bold">Preço (R$)*</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                             @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                     {{-- Estoque (stock_quantity) --}}
                     <div class="col-md-4">
                        <label for="stock_quantity" class="form-label fw-bold">Estoque Inicial</label>
                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}">
                         @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Imagem (image_path) --}}
                    <div class="col-md-4">
                        <label for="image_path" class="form-label fw-bold">Imagem do Produto*</label>
                        <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path" accept="image/png, image/jpeg, image/jpg, image/webp" required>
                        <div class="form-text small">Formatos: JPG, PNG, WebP. Máx: 2MB.</div>
                         @error('image_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Descrição (description) --}}
                    <div class="col-12">
                        <label for="description" class="form-label fw-bold">Descrição Detalhada</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                         @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            <i class="fas fa-save me-2"></i> Salvar Produto
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
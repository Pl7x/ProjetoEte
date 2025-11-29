<div>
    {{-- Mensagens de erro/sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

<input type="text" class="form-control" wire:model="name">
@error('name') 
    <span class="text-danger small d-block mt-1">{{ $message }}</span> 
@enderror
    <form wire:submit.prevent="save">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    {{ $user ? 'Editar Usuário' : 'Novo Usuário' }}
                </h5>
            </div>
            
            <div class="card-body p-4">
                <div class="row g-3">
                    {{-- Nome --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Nome Completo*</label>
                        <input type="text" class="form-control" wire:model="name" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- E-mail --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">E-mail*</label>
                        <input type="email" class="form-control" wire:model="email" required>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- Senha --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Senha {{ $user ? '(Deixe em branco para manter a atual)' : '*' }}
                        </label>
                        <input type="password" class="form-control" wire:model="password">
                        <small class="text-muted">Mínimo de 6 caracteres.</small>
                        @error('password') <div class="d-block text-danger small">{{ $message }}</div> @enderror
                    </div>

                    {{-- Botões --}}
                    <div class="col-12 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <span wire:loading class="spinner-border spinner-border-sm me-2"></span>
                            Salvar
                        </button>
                        <a href="{{ route('usuarios') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
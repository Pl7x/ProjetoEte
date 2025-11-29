<div> {{-- Esta div raiz é OBRIGATÓRIA --}}
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 border-start border-5 border-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit.prevent="save">
        
        {{-- Cabeçalho do Card --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-gray-800 fw-bold">
                {{-- Título Vazio intencional ou coloque um título aqui --}}
            </h2>
            <a href="{{ route('usuarios') }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Voltar
            </a>
        </div>
        <hr>

        <div class="row g-4">
            {{-- Coluna Principal --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 d-flex align-items-center border-bottom-0">
                        <h5 class="m-0 fw-bold text-primary">
                            @if($user)
                                <i class="bi bi-person-gear me-2"></i>Editar Usuário
                            @else
                                <i class="bi bi-person-plus me-2"></i>Novo Usuário
                            @endif
                        </h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Nome --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary">Nome Completo*</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" wire:model="name" placeholder="Ex: Maria Silva" required>
                                </div>
                                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- E-mail --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary">E-mail de Acesso*</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" wire:model="email" placeholder="usuario@exemplo.com" required>
                                </div>
                                @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Senha --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary">Senha {{ $user ? '(Opcional)' : '*' }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" wire:model="password" placeholder="******">
                                </div>
                                <small class="text-muted">Mínimo de 6 caracteres.</small>
                                @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            {{-- Botão Salvar --}}
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" wire:loading.attr="disabled">
                                    <span wire:loading class="spinner-border spinner-border-sm me-2"></span>
                                    {{ $user ? 'Salvar Alterações' : 'Cadastrar Usuário' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Coluna Lateral --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 bg-light mb-4">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-shield-lock-fill display-1 text-secondary opacity-25"></i>
                        <p class="text-muted mt-3 small mb-0">
                            <strong>Segurança:</strong> Utilize uma senha forte para proteger o acesso ao painel administrativo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark">Criar Nova Senha</h4>
                    <p class="text-muted small">Defina sua nova senha de acesso.</p>
                </div>

                <form wire:submit.prevent="resetPassword">
                    <input type="hidden" wire:model="token">
                    
                    <div class="form-floating mb-3">
                        <input type="email" wire:model="email" class="form-control bg-light border-0 rounded-3" readonly placeholder="E-mail">
                        <label>E-mail</label>
                        @error('email') <span class="text-danger small fw-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" wire:model="password" class="form-control bg-light border-0 rounded-3 @error('password') is-invalid @enderror" placeholder="Nova Senha">
                        <label>Nova Senha</label>
                        @error('password') <span class="text-danger small fw-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" wire:model="password_confirmation" class="form-control bg-light border-0 rounded-3" placeholder="Confirmar">
                        <label>Confirmar Nova Senha</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark py-3 fw-bold rounded-3 shadow-sm">
                            <span wire:loading.remove>Redefinir Senha</span>
                            <span wire:loading>Processando...</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
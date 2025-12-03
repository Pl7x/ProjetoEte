<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                
                <div class="text-center mb-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-envelope-exclamation text-warning display-6"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Recuperar Senha</h4>
                    <p class="text-muted small">Digite seu e-mail para receber o link.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success text-center border-0 small fw-bold mb-4">
                        <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
                    </div>
                @endif

                <form wire:submit.prevent="sendResetLink">
                    <div class="form-floating mb-4">
                        <input type="email" wire:model="email" class="form-control bg-light border-0 rounded-3 @error('email') is-invalid @enderror" id="resetEmail" placeholder="email@exemplo.com">
                        <label for="resetEmail">E-mail Cadastrado</label>
                        @error('email') <span class="text-danger small fw-bold ms-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning py-3 fw-bold rounded-3 shadow-sm">
                            <span wire:loading.remove>Enviar Link de Recuperação</span>
                            <span wire:loading><span class="spinner-border spinner-border-sm me-2"></span> Enviando...</span>
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-light py-2 fw-bold text-muted rounded-3">
                            Voltar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
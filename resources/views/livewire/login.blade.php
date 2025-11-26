<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0" style="width: 100%; max-width: 400px;">

        <div class="card-header bg-danger text-white text-center py-4">
            <div class="mb-2">
                <i class="bi bi-shield-lock display-3"></i>
            </div>
            <h4 class="m-0 fw-bold text-uppercase">Área Restrita</h4>
            <small class="text-white-50">Acesso exclusivo para Administradores</small>
        </div>

        <div class="card-body p-4">
            <form wire:submit.prevent="login">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                        <input type="email"
                               class="form-control"
                               wire:model="email"
                               id="email"
                               placeholder="Insira seu e-mail">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="senha" class="form-label fw-bold">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                        <input type="password"
                               class="form-control"
                               wire:model="password"
                               id="senha"
                               placeholder="Insira sua senha">
                    </div>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-danger btn-lg" wire:loading.attr="disabled">
                        <span wire:loading.remove>ENTRAR</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Verificando...
                        </span>
                    </button>
                </div>

                <div class="text-center mb-3">
                    @error('email')
                        <div class="alert alert-warning d-flex align-items-center justify-content-center p-2 mb-2" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $message }}
                        </div>
                    @enderror

                    @error('password')
                        <div class="alert alert-warning d-flex align-items-center justify-content-center p-2 mb-2" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $message }}
                        </div>
                    @enderror

                    @if(session()->has('error'))
                        <div class="alert alert-danger d-flex align-items-center justify-content-center p-2" role="alert">
                            <i class="bi bi-shield-x me-2"></i> {{ session()->get('error') }}
                        </div>
                    @endif
                </div>

                <div class="text-center border-top pt-3">

                    <a href="{{ route ('home') }}" class="text-decoration-none text-secondary mt-2 d-inline-block">
                        <i class="bi bi-arrow-left"></i> Voltar ao site
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

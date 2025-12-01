<div class="p-3">
    @if(Auth::guard('client')->check())
        {{-- SE ESTIVER LOGADO COMO CLIENTE --}}
        <div class="text-center mb-4">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                {{-- CORREÇÃO: Usar guard('client')->user() --}}
                <span class="fs-3 fw-bold text-dark">{{ substr(Auth::guard('client')->user()->name, 0, 1) }}</span>
            </div>
            
            {{-- CORREÇÃO: Usar guard('client')->user() --}}
            <h5 class="fw-bold mb-0">Olá, {{ strtok(Auth::guard('client')->user()->name, ' ') }}!</h5>
            
            {{-- CORREÇÃO: Usar guard('client')->user() --}}
            <small class="text-muted">{{ Auth::guard('client')->user()->email }}</small>
        </div>

        <div class="list-group list-group-flush mb-4">
            <a href="#" class="list-group-item list-group-item-action border-0 px-2">
                <i class="bi bi-bag-check-fill me-2 text-warning"></i> Meus Pedidos
            </a>
        </div>

        <div class="d-grid">
            <button wire:click="logout" class="btn btn-outline-danger btn-sm">Sair</button>
        </div>

    @else
        {{-- SE NÃO ESTIVER LOGADO --}}
        <div class="text-center mb-4">
            <h4 class="fw-bold">Bem-vindo!</h4>
            <p class="text-muted small">Faça login para continuar.</p>
        </div>

        <form wire:submit.prevent="login">
            <div class="mb-3">
                <label class="form-label small fw-bold">E-mail</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                    <input type="email" wire:model="email" class="form-control border-start-0" placeholder="exemplo@email.com">
                </div>
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Senha</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-key"></i></span>
                    <input type="password" wire:model="password" class="form-control border-start-0" placeholder="******">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" wire:model="remember">
                    <label class="form-check-label small text-muted" for="remember">Lembrar-me</label>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-warning fw-bold text-dark">Entrar</button>
            </div>
        </form>
    @endif
</div>
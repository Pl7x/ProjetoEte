<div class="p-3">
    @auth
        {{-- MENU DO CLIENTE LOGADO --}}
        <div class="text-center mb-4">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                <span class="fs-3 fw-bold text-dark">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <h5 class="fw-bold mb-0">Olá, {{ strtok(Auth::user()->name, ' ') }}!</h5>
            <small class="text-muted">{{ Auth::user()->email }}</small>
        </div>

        <div class="list-group list-group-flush mb-4">
            <a href="#" class="list-group-item list-group-item-action border-0 px-2">
                <i class="bi bi-bag-check-fill me-2 text-warning"></i> Meus Pedidos
            </a>
            
            {{-- Se for ADMIN, mostra botão extra --}}
            @if(Auth::user()->is_admin)
                <a href="{{ route('painel') }}" class="list-group-item list-group-item-action border-0 px-2 fw-bold text-primary">
                    <i class="bi bi-speedometer2 me-2"></i> Ir para Painel Admin
                </a>
            @endif
        </div>

        <div class="d-grid">
            <button wire:click="logout" class="btn btn-outline-danger btn-sm">
                Sair da Conta
            </button>
        </div>

    @else
        {{-- FORMULÁRIO DE LOGIN DE CLIENTE --}}
        <div class="text-center mb-4">
            <h4 class="fw-bold">Bem-vindo(a)!</h4>
            <p class="text-muted small">Faça login para continuar.</p>
        </div>

        <form wire:submit.prevent="login">
            <div class="mb-3">
                <label class="form-label small fw-bold">E-mail</label>
                <input type="email" wire:model="email" class="form-control" placeholder="exemplo@email.com">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Senha</label>
                <input type="password" wire:model="password" class="form-control" placeholder="******">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-warning fw-bold text-dark">Entrar</button>
            </div>
        </form>
    @endauth
</div>
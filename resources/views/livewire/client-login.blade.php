<div class="p-3">
    @auth
        {{-- VISÃO LOGADO --}}
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
            @if(Auth::user()->is_admin)
                <a href="{{ route('painel') }}" class="list-group-item list-group-item-action border-0 px-2 fw-bold text-primary">
                    <i class="bi bi-speedometer2 me-2"></i> Painel Admin
                </a>
            @endif
        </div>

        <div class="d-grid">
            <button wire:click="logout" class="btn btn-outline-danger btn-sm">Sair</button>
        </div>

    @else
        {{-- VISÃO FORMULÁRIO --}}
        <div class="text-center mb-4">
            <h4 class="fw-bold">Bem-vindo!</h4>
            <p class="text-muted small">Faça login para continuar.</p>
        </div>

        <form wire:submit.prevent="login">
            <div class="mb-3">
                <input type="email" wire:model="email" class="form-control" placeholder="E-mail">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <input type="password" wire:model="password" class="form-control" placeholder="Senha">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-warning fw-bold">Entrar</button>
            </div>
        </form>
    @endauth
</div>
<div class="px-3 py-2">
    {{-- VERIFICAÇÃO: SE ESTIVER LOGADO --}}
    @if(Auth::guard('client')->check())
        
        {{-- 
            PAINEL DO CLIENTE 
            (Aqui só mostramos os dados do usuário e o botão de sair)
        --}}
        <div class="text-center mb-4">
            <div class="position-relative d-inline-block mb-3">
                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center shadow-sm" 
                     style="width: 85px; height: 85px; font-size: 2.2rem; font-weight: 800; border: 4px solid #fff;">
                    {{ substr(Auth::guard('client')->user()->name, 0, 1) }}
                </div>
                <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-2 border-white rounded-circle"></span>
            </div>
            
            <h5 class="fw-bold text-dark mb-0">Olá, {{ strtok(Auth::guard('client')->user()->name, ' ') }}!</h5>
            <small class="text-muted">{{ Auth::guard('client')->user()->email }}</small>
        </div>

        <div class="list-group list-group-flush mb-4 rounded-4 shadow-sm bg-white border overflow-hidden">
           <a href="#" data-bs-toggle="modal" data-bs-target="#meusPedidosModal" class="list-group-item list-group-item-action px-4 py-3 border-bottom d-flex align-items-center hover-bg-light">
                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3 text-warning">
                    <i class="bi bi-bag-check-fill fs-5"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Meus Pedidos</h6>
                </div>
                <i class="bi bi-chevron-right text-muted small"></i>
            </a>
            
            <a href="#" data-bs-toggle="modal" data-bs-target="#clientSettingsModal" class="list-group-item list-group-item-action px-4 py-3 d-flex align-items-center hover-bg-light">
                <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3 text-secondary">
                    <i class="bi bi-person-gear fs-5"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Minha Conta</h6>
                </div>
                <i class="bi bi-chevron-right text-muted small"></i>
            </a>
        </div>

        <button wire:click="logout" class="btn btn-outline-danger w-100 py-3 fw-bold rounded-3 text-uppercase shadow-sm" style="font-size: 0.8rem; letter-spacing: 1px;">
            <i class="bi bi-box-arrow-right me-2"></i> Sair da Conta
        </button>

    {{-- SE NÃO ESTIVER LOGADO (MOSTRA LOGIN + CRIAR CONTA) --}}
    @else
        
        <div class="text-center mb-4">
            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" 
                 style="width: 70px; height: 70px;">
                <i class="bi bi-person-lock text-warning" style="font-size: 2rem;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">Bem-vindo(a)!</h4>
            <p class="text-muted small mb-0">Digite seus dados para acessar a loja.</p>
        </div>

        <form wire:submit.prevent="login" class="px-1">
            
            <div class="form-floating mb-3">
                <input type="email" wire:model="email" class="form-control bg-light border-light-subtle rounded-3 shadow-sm ps-4 @error('email') is-invalid @enderror" id="emailInput" placeholder="name@example.com" style="height: 55px;">
                <label for="emailInput" class="text-muted ps-4 small"><i class="bi bi-envelope me-2"></i>E-mail</label>
                @error('email') <span class="text-danger small fw-bold ms-2">{{ $message }}</span> @enderror
            </div>

            <div class="form-floating mb-2">
                <input type="password" wire:model="password" class="form-control bg-light border-light-subtle rounded-3 shadow-sm ps-4 @error('password') is-invalid @enderror" id="passwordInput" placeholder="Password" style="height: 55px;">
                <label for="passwordInput" class="text-muted ps-4 small"><i class="bi bi-key me-2"></i>Senha</label>
                @error('password') <span class="text-danger small fw-bold ms-2">{{ $message }}</span> @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-1 mt-3">
                <div class="form-check">
                    <input class="form-check-input border-secondary" type="checkbox" id="remember" wire:model="remember" style="cursor: pointer;">
                    <label class="form-check-label small text-secondary cursor-pointer" for="remember">Lembrar</label>
                </div>
                <a href="{{ route('client.password.request') }}" class="small text-decoration-none fw-bold text-warning hover-opacity-75">
                     Esqueceu a senha?
                </a>
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-warning py-3 rounded-3 fw-bold text-dark shadow-sm text-uppercase" style="letter-spacing: 0.5px;">
                    <span wire:loading.remove>Acessar Conta</span>
                    <span wire:loading><i class="bi bi-hourglass-split"></i> Entrando...</span>
                </button>
            </div>

            {{-- 
               ESTA PARTE AGORA ESTÁ DENTRO DO ELSE
               Só aparecerá se o usuário NÃO estiver logado
            --}}
            <div class="text-center position-relative mb-4">
                <hr class="text-muted opacity-25">
                <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 small text-muted">
                    Novo por aqui?
                </span>
            </div>

            <div class="d-grid">
                <button type="button" wire:click="$parent.toggleMode()" class="btn btn-outline-dark py-2 rounded-3 fw-bold small shadow-sm border-2">
                    CRIAR MINHA CONTA
                </button>
            </div>

        </form>
    @endif
</div>
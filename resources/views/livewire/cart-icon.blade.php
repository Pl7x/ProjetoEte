<div>
    {{-- 
        LÓGICA DO ÍCONE:
        - Logado: Abre o Offcanvas do Carrinho
        - Deslogado: Abre o Modal de Autenticação
    --}}
    @if(Auth::guard('client')->check())
        <a href="#" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold position-relative"
           data-bs-toggle="offcanvas" 
           data-bs-target="#cartOffcanvas">
            <i class="bi bi-bag-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-dark">
                {{ count(session('cart', [])) }}
            </span>
        </a>
    @else
        <a href="#" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold position-relative"
           data-bs-toggle="modal" 
           data-bs-target="#authModal"> {{-- Abre o Login direto --}}
            <i class="bi bi-bag-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary border border-dark">
                <i class="bi bi-lock-fill" style="font-size: 0.6rem;"></i>
            </span>
        </a>
    @endif
</div>
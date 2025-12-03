<div>
    {{-- 
        CORREÇÃO: 
        O botão agora tem UM único alvo: #cartOffcanvas.
        Independente de estar logado ou não, ele abre a barra lateral.
    --}}
    <a href="#" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold position-relative"
       data-bs-toggle="offcanvas" 
       data-bs-target="#cartOffcanvas">
        
        <i class="bi bi-bag-fill"></i>
        
        {{-- Apenas o "enfeite" (badge) muda: --}}
        @if(Auth::guard('client')->check())
            {{-- Se logado: Mostra o número de itens --}}
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-dark">
                {{ $count }}
            </span>
        @else
            {{-- Se deslogado: Mostra um cadeado cinza --}}
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary border border-dark">
                <i class="bi bi-lock-fill" style="font-size: 0.6rem;"></i>
            </span>
        @endif
    </a>
</div>
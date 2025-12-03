<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SuppStore') }} @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bs-font-sans-serif: 'Inter', system-ui, -apple-system, sans-serif;
            --primary-color: #ffc107;
        }

        body {
            font-family: var(--bs-font-sans-serif);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .navbar-brand { letter-spacing: -0.5px; }
        .nav-link { font-weight: 500; }
        .nav-link.active { color: var(--primary-color) !important; }

        footer a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: color 0.2s;
        }
        footer a:hover { color: var(--primary-color); }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #aaa; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 1. Estilos do Livewire --}}
    @livewireStyles

    @stack('styles')
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center fs-4" href="{{ url('/') }}">
                <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                SuppStore
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/') }}">Início</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Produtos</a>
                        <ul class="dropdown-menu border-0 shadow">
    
    {{-- 1. Busca as categorias do banco de dados --}}
    @php
        // Usamos o caminho completo da Model para não precisar de 'use' no topo
        $navbarCategories = \App\Models\Category::all();
    @endphp

    {{-- 2. Loop para criar um link para cada categoria --}}
    @foreach($navbarCategories as $cat)
        <li>
            {{-- 
               O segredo está aqui: passamos um array para a rota 'catalogo'.
               O Laravel transforma isso em ?categoria=ID na URL.
            --}}
            <a class="dropdown-item" href="{{ route('catalogo', ['categoria' => $cat->id]) }}">
                {{ $cat->name }}
            </a>
        </li>
    @endforeach

    {{-- Se não tiver categorias cadastradas, mostra uma mensagem --}}
    @if($navbarCategories->isEmpty())
        <li><span class="dropdown-item text-muted small">Sem categorias</span></li>
        
    @endif

    <li><hr class="dropdown-divider"></li>
    
    {{-- Link para limpar filtros (Ver Tudo) --}}
    <li>
        <a class="dropdown-item fw-bold" href="{{ route('catalogo') }}">
            Ver Tudo
        </a>
    </li>
</ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('sobre') }}">Blog</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    {{-- Botão de Login / Perfil --}}
                    <a href="#" class="text-white opacity-75 hover-opacity-100 transition" 
                    data-bs-toggle="modal" 
                    data-bs-target="#authModal">
                        <i class="bi bi-person fs-5"></i>
                    </a>

                    {{-- 
                        BOTÃO DO CARRINHO (COMPONENTE LIVEWIRE)
                        Substituímos o código estático por este componente.
                        Ele ouve o evento 'cart-updated' e atualiza o número sozinho.
                    --}}
                    <livewire:cart-icon />
                    
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('conteudo')
    </main>

    <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-warning">
                        <i class="bi bi-fire"></i> SuppStore
                    </h5>
                    <p>Sua jornada para uma vida mais saudável e forte começa aqui. Qualidade e confiança em suplementos.</p>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Institucional</h5>
                    <p><a href="{{ route('sobre') }}">Sobre Nós</a></p>
                    <p><a href="{{ route('politicas') }}">Políticas de Privacidade</a></p>
                    <p><a href="{{ route('trocas') }}">Trocas e Devoluções</a></p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Contato</h5>
                    <p><i class="bi bi-geo-alt-fill me-2 text-warning"></i> Rua Fitness, 123, São Paulo - SP</p>
                    <p><i class="bi bi-envelope-fill me-2 text-warning"></i> contato@suppstore.com</p>
                    <p><i class="bi bi-whatsapp me-2 text-warning"></i> (11) 99999-8888</p>
                </div>
            </div>

            <hr class="mb-4 mt-4 border-secondary">

            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p class="text-center text-md-start mb-0">© {{ date('Y') }} Copyright:
                        <a href="#" class="text-warning text-decoration-none">
                            <strong>SuppStore.com</strong>
                        </a> | Todos os direitos reservados.
                    </p>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="text-center text-md-end mt-3 mt-md-0">
                        <a href="#" class="btn btn-outline-light btn-sm btn-floating m-1"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm btn-floating m-1"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm btn-floating m-1"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- MODAL DE LOGIN/REGISTRO --}}
    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body p-0">
                    <livewire:auth-modal />
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- COMPONENTE DO CARRINHO (BARRA LATERAL) --}}
    <livewire:cart-bar />
    
    @livewireScripts

   <script>
        // Funções de Máscara (Globais)
        function mascaraCPF(i) {
            var v = i.value;
            if(v.length > 14) { i.value = v.substring(0, 14); return; }
            v = v.replace(/\D/g, "");
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            i.value = v;
            i.dispatchEvent(new Event('input'));
        }

        function mascaraCEP(i) {
            var v = i.value;
            if(v.length > 9) { i.value = v.substring(0, 9); return; }
            v = v.replace(/\D/g, "");
            v = v.replace(/^(\d{5})(\d)/, "$1-$2");
            i.value = v;
            i.dispatchEvent(new Event('input'));
        }

        // Listeners do Livewire
        document.addEventListener('livewire:initialized', () => {
            
            // Abre modal de login
            Livewire.on('open-auth-modal', () => {
                const el = document.getElementById('quickViewModal');
                if (el) bootstrap.Modal.getInstance(el)?.hide();
                const authModal = new bootstrap.Modal(document.getElementById('authModal'));
                authModal.show();
            });

            // Fecha modal de produto
            Livewire.on('close-quick-view', () => {
                const el = document.getElementById('quickViewModal');
                if (el) bootstrap.Modal.getInstance(el)?.hide();
            });

            // Abre o carrinho lateral
            Livewire.on('open-cart', () => {
                const el = document.getElementById('cartOffcanvas');
                const offcanvas = new bootstrap.Offcanvas(el);
                offcanvas.show();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
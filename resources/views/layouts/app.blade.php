<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>{{ config('app.name', 'SuppStore') }} @yield('title')</title>

    <!-- Estilos do Tema -->
    <style>
        :root {
            --primary-color: #ffc107; /* Warning do Bootstrap */
            --dark-bg: #212529;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Ajustes da Navbar */
        .navbar-brand i {
            font-size: 1.5rem;
        }

        /* Footer Links Hover */
        .footer-link {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer-link:hover {
            color: #ffc107; /* Amarelo Warning */
        }

        /* Garante que o footer fique no final mesmo com pouco conteúdo */
        main {
            flex: 1;
        }
    </style>

    {{-- Diretivas do Laravel --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
                <i class="bi bi-fire text-warning me-2"></i>
                SuppStore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Início</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produtos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Proteínas</a></li>
                            <li><a class="dropdown-item" href="#">Pré-Treinos</a></li>
                            <li><a class="dropdown-item" href="#">Vitaminas</a></li>
                            <li><a class="dropdown-item" href="#">Creatinas</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('sobre')}}">Sobre Nós</a>
                    </li>
                </ul>


                <!-- Ícones de Usuário e Carrinho -->
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-outline-light" title="Minha Conta">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <a href="#" class="btn btn-warning position-relative" title="Carrinho">
                        <i class="bi bi-cart-fill"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal Dinâmico -->
    <main>
        @yield('conteudo')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">

                <!-- Logo e Slogan -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-warning">
                        <i class="bi bi-fire"></i> SuppStore
                    </h5>
                    <p>Sua jornada para uma vida mais saudável e forte começa aqui. Qualidade e confiança em suplementos.</p>
                </div>



                <!-- Institucional -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Institucional</h5>
                    <a href="{{route('sobre')}}" class="footer-link">Sobre Nós</a></p>
                    <p><a href="{{ route('politicas') }}" class="footer-link">Políticas de Privacidade</a></p>
                    <p><a href="{{ route('trocas') }}" class="footer-link">Trocas e Devoluções</a></p>
                </div>

                <!-- Contato -->
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

    {{-- Scripts do Laravel --}}
    @livewireScripts
    @stack('scripts')

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>{{config('app.name')}} @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .main-container {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: #212529;
            color: white;
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            width: 100%;
            overflow-y: auto;
            padding: 0;
        }

        .main-content .container {
            width: 100%;
            max-width: 100%;
            padding: 1.5rem;
            margin-top: 0;
        }
    </style>
</head>
<body>
<div class="d-flex main-container">

    <div class="d-flex flex-column flex-shrink-0 p-3 sidebar">

      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-shield-lock-fill me-2 fs-4"></i>
        <span class="fs-4">Painel Admin</span>
      </a>
      <hr>

      <ul class="nav nav-pills flex-column mb-auto">

        <li class="sidebar-heading">Principal</li>

        <li class="nav-item">
          <a href="{{route('painel')}}" class="nav-link {{request()->routeIs('painel') ? 'active' : ''}}">
            <i class="bi bi-house-door-fill me-2"></i>
            Dashboard
          </a>
        </li>


        <li class="nav-item">
          <a href="{{route('produtos')}}" class="nav-link {{request()->routeIs('produtos') ? 'active' : ''}}">
            <i class="bi bi-box-seam-fill me-2"></i>
            Produtos
          </a>
        </li>


        <li class="nav-item">
          <a href="#submenu-vendas"
             class="nav-link d-flex align-items-center"
             data-bs-toggle="collapse" role="button"
             aria-controls="submenu-vendas">
            <i class="bi bi-cart-fill me-2"></i>
            Vendas
          </a>

          <div class="collapse " id="submenu-vendas">
            <ul class="nav flex-column submenu">

              <li class="nav-item">
                <a href="{{route('pedidos')}}" class="nav-link {{request()->routeIs('pedidos') ? 'active' : ''}}">
                    <i class="bi bi-bag-check-fill"></i>
                   Pedidos
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('relatorio')}}" class="nav-link {{request()->routeIs('relatorio') ? 'active' : ''}}">
                    <i class="bi bi-bar-chart-line-fill"></i>
                   Relatórios
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
            <a href="{{route('usuarios')}}" class="nav-link {{request()->routeIs('usuarios') ? 'active' : ''}}">
            <i class="bi bi-people-fill me-2"></i>
            Usuários
          </a>
        </li>

        <li class="sidebar-heading">Configurações</li>

        <li class="nav-item">
          <a href="#" class="nav-link {{request()->routeIs('#') ? 'active' : ''}}">
            <i class="bi bi-gear-fill me-2"></i>
            Geral
          </a>
        </li>

      </ul>

      <hr>



      <div class="dropdown user-dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">

          <strong class="ms-2"><i class="bi bi-person-circle"></i> Admin</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">


          <li><a class="dropdown-item" href="{{ route ('logout') }}">
            <i class="bi bi-box-arrow-right me-2"></i>
            Sair
          </a></li>
        </ul>
      </div>
    </div>

    <div class="main-content">
        <div class="container">
            @yield('conteudo')
        </div>
    </div>

</div>

    @livewireScripts
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

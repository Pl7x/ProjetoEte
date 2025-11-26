<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>{{config('app.name')}} @yield('title')</title>

    @livewireStyles
    @stack('styles')
</head>
<body>

<div class="card shadow p-4" style="width: 100%; max-width: 400px; margin: auto; margin-top: 50px;">
    <h3 class="text-center mb-4">Registrar-se</h3>

    <form>
      <!-- Nome -->
      <div class="mb-3">
        <label for="nome" class="form-label">Nome completo</label>
        <input type="text" class="form-control" id="nome" placeholder="Digite seu nome" required>
      </div>

      <!-- E-mail -->
      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
      </div>

      <!-- Senha -->
      <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senha" placeholder="Digite sua senha" required>
      </div>

      <!-- Confirmar senha -->
      <div class="mb-3">
        <label for="confirmar" class="form-label">Confirmar senha</label>
        <input type="password" class="form-control" id="confirmar" placeholder="Repita sua senha" required>
      </div>

      <!-- Aceitar termos -->
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="termos" required>
        <label class="form-check-label" for="termos">Aceito os termos de uso</label>
      </div>

      <!-- Botão de registrar -->
      <button type="submit" class="btn btn-success w-100 mb-3">Registrar</button>

      <!-- Link para login -->
      <div class="text-center">
        <a href="/login" class="text-decoration-none">Já tem uma conta? Fazer login</a>
      </div>
    </form>
  </div>


    @livewireScripts
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

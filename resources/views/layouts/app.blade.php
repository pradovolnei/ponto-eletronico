<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>@yield('title', 'Ponto Eletrônico')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Ponto</a>
    <div class="">
      @auth
        <span class="me-2">Olá, {{ auth()->user()->name }}</span>
        @if(auth()->user()->isAdmin())
          <a href="{{ route('employees.index') }}" class="btn btn-sm btn-primary me-2">Funcionários</a>
          <a href="{{ route('reports.index') }}" class="btn btn-sm btn-info">Relatórios</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button class="btn btn-sm btn-danger">Sair</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login</a>
      @endauth
    </div>
  </div>
</nav>

<div class="container">
    @includeWhen(session('success'), 'partials.alerts')
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

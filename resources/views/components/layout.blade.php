<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .container {
            margin-top: 40px;
            margin-bottom: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 32px 24px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Préstamos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/catalogos/puestos') }}">Puestos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/catalogos/empleados') }}">Empleados</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/movimientos/prestamos') }}">Préstamos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/reportes') }}">Reportes</a></li>
                    @auth
                        <li class="nav-item">
                            <form action="{{ url('/logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="display:inline; padding:0; border:none; background:none; color:#fff;">Salir</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Entrar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        @guest
            <div class="alert alert-warning text-center">
                Debes iniciar sesión para ver los datos guardados.
            </div>
        @endguest
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

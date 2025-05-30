
@if(Auth::check())
<nav class="sidebar nav flex-column pt-5 px-3">
    <a href="{{ url('/catalogos/puestos') }}" class="nav-link d-flex align-items-center mb-2">
        <span class="me-2"><i class="bi bi-person-badge"></i></span> Puestos
    </a>
    <a href="{{ url('/catalogos/empleados') }}" class="nav-link d-flex align-items-center mb-2">
        <span class="me-2"><i class="bi bi-people"></i></span> Empleados
    </a>
    <a href="{{ url('/movimientos/prestamos') }}" class="nav-link d-flex align-items-center mb-2">
        <span class="me-2"><i class="bi bi-cash-stack"></i></span> Préstamos
    </a>
    <a href="{{ url('/reportes/') }}" class="nav-link d-flex align-items-center mb-2">
        <span class="me-2"><i class="bi bi-bar-chart"></i></span> Reportes
    </a>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link d-flex align-items-center mt-4">
        <span class="me-2"><i class="bi bi-box-arrow-right"></i></span> Salir
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
@endif
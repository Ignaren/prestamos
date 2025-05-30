@if(Auth::check())
<nav class="sidebar nav flex-column pt-4 px-3">
    <div class="mb-4 text-center">
        <i class="bi bi-gem" style="font-size:2.5rem; color:#ff7f7f;"></i>
        <div class="fw-bold mt-2" style="color:#ff7f7f; letter-spacing:1px;">Menú</div>
    </div>
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
    <div class="mt-auto pt-4">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link d-flex align-items-center">
            <span class="me-2"><i class="bi bi-box-arrow-right"></i></span> Salir
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
@endif
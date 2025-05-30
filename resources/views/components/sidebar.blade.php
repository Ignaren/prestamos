
@if(Auth::check())
<nav class="sidebar nav flex-column pt-4 px-3" style="background: linear-gradient(135deg, #ffd6d6 70%, #ffeaea 100%); min-height: 100vh; box-shadow: 2px 0 18px rgba(255,127,127,0.10);">
    <div class="mb-4 text-center">
        <i class="bi bi-gem" style="font-size:2.5rem; color:#ff7f7f;"></i>
        <div class="fw-bold mt-2" style="color:#ff7f7f; letter-spacing:1px;">Menú</div>
    </div>
    <a href="{{ url('/catalogos/puestos') }}" class="nav-link d-flex align-items-center mb-2"
       style="background: linear-gradient(90deg, #ff7f7f 60%, #ffb3b3 100%); color: #fff; border-radius: 0.7rem; font-weight:600; margin-bottom:0.7rem; padding:0.8rem 1.2rem; box-shadow:0 2px 12px #ff7f7f22; transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.3s;">
        <span class="me-2"><i class="bi bi-person-badge"></i></span> Puestos
    </a>
    <a href="{{ url('/catalogos/empleados') }}" class="nav-link d-flex align-items-center mb-2"
       style="background: linear-gradient(90deg, #ff7f7f 60%, #ffb3b3 100%); color: #fff; border-radius: 0.7rem; font-weight:600; margin-bottom:0.7rem; padding:0.8rem 1.2rem; box-shadow:0 2px 12px #ff7f7f22; transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.3s;">
        <span class="me-2"><i class="bi bi-people"></i></span> Empleados
    </a>
    <a href="{{ url('/movimientos/prestamos') }}" class="nav-link d-flex align-items-center mb-2"
       style="background: linear-gradient(90deg, #ff7f7f 60%, #ffb3b3 100%); color: #fff; border-radius: 0.7rem; font-weight:600; margin-bottom:0.7rem; padding:0.8rem 1.2rem; box-shadow:0 2px 12px #ff7f7f22; transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.3s;">
        <span class="me-2"><i class="bi bi-cash-stack"></i></span> Préstamos
    </a>
    <a href="{{ url('/reportes/') }}" class="nav-link d-flex align-items-center mb-2"
       style="background: linear-gradient(90deg, #ff7f7f 60%, #ffb3b3 100%); color: #fff; border-radius: 0.7rem; font-weight:600; margin-bottom:0.7rem; padding:0.8rem 1.2rem; box-shadow:0 2px 12px #ff7f7f22; transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.3s;">
        <span class="me-2"><i class="bi bi-bar-chart"></i></span> Reportes
    </a>
    <div class="mt-auto pt-4">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link d-flex align-items-center"
           style="background: linear-gradient(90deg, #fff 60%, #ffd6d6 100%); color: #ff7f7f; border-radius: 0.7rem; font-weight:600; margin-bottom:0.7rem; padding:0.8rem 1.2rem; box-shadow:0 2px 12px #ff7f7f22; transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.3s;">
            <span class="me-2"><i class="bi bi-box-arrow-right"></i></span> Salir
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>
@endif
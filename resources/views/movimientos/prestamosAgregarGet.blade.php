@extends("components.layout")
@section("content")
@component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
@endcomponent

<h1>Agregar préstamo</h1>

<form method="post" action="{{ url('/movimientos/prestamos/agregar') }}">
    @csrf

    <div class="form-group mb-3">
        <label for="fk_id_empleado">Empleado:</label>
        <select class="form-select" name="fk_id_empleado" id="fk_id_empleado" required autofocus>
            <option value="">Selecciona un empleado</option>
            @foreach($empleados as $empleado)
                <option value="{{ $empleado->id_empleado }}">
                    {{ $empleado->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="form-group mb-3 col-2">
            <label for="fecha_solicitud">Fecha de solicitud</label>
            <input type="date" name="fecha_solicitud" id="fecha_solicitud" class="form-control" required>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="monto">Monto</label>
            <input type="number" name="monto" id="monto" class="form-control" required>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="plazo">Plazo (meses)</label>
            <input type="number" min="1" max="24" name="plazo" id="plazo" class="form-control" required>
            <div class="invalid-feedback">
                Ingresa un número válido
            </div>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="tasa_mensual">Tasa mensual</label>
            <input value="1" type="number" name="tasa_mensual" id="tasa_mensual" class="form-control" required>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="fecha_ini_desc">Fecha inicio descuento</label>
            <input type="date" name="fecha_ini_desc" id="fecha_ini_desc" class="form-control" required>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="fecha_fin_desc">Fecha fin descuento</label>
            <input readonly type="date" name="fecha_fin_desc" id="fecha_fin_desc" class="form-control" required>
        </div>
    </div>

    <div class="row">
        <div class="form-group mb-3 col-2">
            <label for="pago_fijo_cap">Pago fijo capital</label>
            <input readonly type="number" step="0.01" name="pago_fijo_cap" id="pago_fijo_cap" class="form-control" required>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="saldo_actual">Saldo actual</label>
            <input type="number" step="0.01" name="saldo_actual" id="saldo_actual" class="form-control" required>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="fecha_aprob">Fecha de aprobación</label>
            <input type="date" name="fecha_aprob" id="fecha_aprob" class="form-control" required>
        </div>
        <div class="form-group mb-3 col-2">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control" required>
                <option>Solicitado</option>
                <option>Aprobado</option>
                <option>Concluido</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col"></div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>

<script>
(function(){
    let inpmonto=document.getElementById("monto");
    let inpplazo=document.getElementById("plazo");
    let inppagofijocap=document.getElementById("pago_fijo_cap");
    let inpfechainidesc=document.getElementById("fecha_ini_desc");
    let inpfechafindesc=document.getElementById("fecha_fin_desc");
    function calculopagofijocapital(){
        if (!inpmonto.value || !inpplazo.value) {
            return
        }
        inppagofijocap.value=inpmonto.value/inpplazo.value;
    }
    inpmonto.addEventListener("input",calculopagofijocapital);
    inpplazo.addEventListener("input",calculopagofijocapital);
    function calculofechafinplazo(){
        if (!inpplazo.value || !inpfechainidesc.value) {
            return
        }
        let fechainicio=new Date(inpfechainidesc.value);
        let meses=parseInt(inpplazo.value);
        let fechafin=new Date(fechainicio);
        fechafin.setMonth(fechainicio.getMonth()+meses-1);
        inpfechafindesc.value=fechafin.toISOString().slice(0,10);
    }
    inpplazo.addEventListener("input",calculofechafinplazo);
    inpfechainidesc.addEventListener("input",calculofechafinplazo);
})()
</script>

@endsection

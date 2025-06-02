<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\Prestamo;
use App\Models\Abono;
use Carbon\Carbon;
Use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MovimientosController extends Controller
{
    public function prestamosGet(): View{
        $prestamos = Prestamo::join("empleado", "prestamo.fk_id_empleado", "=", "empleado.id_empleado") -> get();
        return view ('movimientos/prestamosGet', [
            'prestamos' => $prestamos,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos")
            ]
        ]);
    }

    public function prestamosAgregarGet(): View 
    {
        $haceunanno = (new DateTime("-1 year"))->format("Y-m-d");
        $empleados = Empleado::where("fecha_ingreso", "<", $haceunanno)->get()->all();
        $fecha_actual = SupportCarbon::now();
        $prestamosvigentes = Prestamo::where("fecha_ini_desc", "<=", $fecha_actual)
            ->where("fecha_fin_desc", ">=", $fecha_actual)
            ->get()
            ->all();
        $empleados = array_column($empleados, null, "fk_id_empleado");
        $prestamosvigentes = array_column($prestamosvigentes, null, "fk_id_empleado");
        $empleados = array_diff_key($empleados, $prestamosvigentes);

        return view('movimientos/prestamosAgregarGet', [  // Sin la "/" antes
            "empleados" => $empleados,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos"),
                "Agregar" => url("/movimientos/prestamos/agregar")
            ]
        ]);
    }

    public function prestamosAgregarPost(Request $request)
    {
        $fecha_ini_desc = $request->input('fecha_ini_desc');
        $plazo = (int) $request->input('plazo'); // <-- Aquí conviertes a entero

        $fecha_fin_desc = \Carbon\Carbon::parse($fecha_ini_desc)->addMonths($plazo)->format('Y-m-d');

        // Crea el préstamo con todos los campos necesarios
        $prestamo = new Prestamo([
            'fk_id_empleado'   => $request->input('fk_id_empleado'),
            'fecha_solicitud'  => $request->input('fecha_solicitud'),
            'monto'            => $request->input('monto'),
            'plazo'            => $plazo,
            'tasa_mensual'     => $request->input('tasa_mensual'),
            'pago_fijo_cap'    => $request->input('pago_fijo_cap'),
            'fecha_ini_desc'   => $fecha_ini_desc,
            'fecha_fin_desc'   => $fecha_fin_desc,
            'estado'           => $request->input('estado'),
        ]);
        $prestamo->save();

        // Redirige o muestra mensaje de éxito
        return redirect('/movimientos/prestamos')->with('success', 'Préstamo guardado correctamente');
    }

    public function abonosGet($id_prestamo): View
    {
        $abonos = Abono::where("fk_id_prestamo", $id_prestamo)->get();

        $prestamo = Prestamo::with('empleado')->where("id_prestamo",$id_prestamo)->first();

        return view('movimientos/abonosGet',[
            'abonos' => $abonos,
            'prestamo' => $prestamo,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos"),
                "Abonos" => url("/movimientos/prestamos/abonos")
            ]
        ]);
    }

    public function abonosAgregarGet($id_prestamo): View
    {
        $prestamo = Prestamo::join("empleado", "empleado.id_empleado", "=", "prestamo.fk_id_empleado")
            ->where("id_prestamo", $id_prestamo)->first();
    
            $abonos = Abono::where("abono.fk_id_prestamo", $id_prestamo)->get();
            $num_abono = count($abonos) + 1;
        
        $pago_fijo_cap=$prestamo->pago_fijo_cap;
        $monto_interes=$prestamo->saldo_actual*$prestamo->tasa_mensual/100;
        $monto_cobrado=$prestamo->pago_fijo_cap+$monto_interes;
        $saldo_pendiente=$prestamo->saldo_actual-$prestamo->pago_fijo_cap;

        if ($saldo_pendiente < 0) {
            $pago_fijo_cap-= $saldo_pendiente;
            $saldo_pendiente=0;
        }
        // Obtener el último abono registrado
        
        //$ultimo_abono = Abono::where("abono.fk_id_prestamo", $id_prestamo)
          //  ->orderBy("fecha", "desc")
            //->first();
    
        // Si hay un abono previo, tomamos su saldo actual, si no, usamos el saldo del préstamo
        //$saldo_actual = $ultimo_abono ? $ultimo_abono->saldo_actual : $prestamo->saldo_actual;
        
        // Cálculo basado en el saldo actual correcto
        //$monto_interes = $saldo_actual * ($prestamo->tasa_mensual / 100);
        //$monto_cobrado = $prestamo->pago_fijo_cap + $monto_interes;
        //$saldo_pendiente = $saldo_actual - $prestamo->pago_fijo_cap;
    
        //if ($saldo_pendiente < 0) {
          //  $pago_fijo_cap = $prestamo->pago_fijo_cap + $saldo_pendiente;
           // $saldo_pendiente = 0;
        //} else {
         //   $pago_fijo_cap = $prestamo->pago_fijo_cap;
        //}
    
        return view('movimientos/abonosAgregarGet', [
            'prestamo' => $prestamo,
            'num_abono' => $num_abono,
            'pago_fijo_cap' => $pago_fijo_cap,
            'monto_interes' => $monto_interes,
            'monto_cobrado' => $monto_cobrado,
            'saldo_pendiente' => $saldo_pendiente,
            'breadcrumbs' => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos"),
                "Abonos" => url("/prestamos/{$prestamo->id_prestamo}/abonos"),
                "Agregar" => "",
            ]
        ]);
    }

    public function abonosAgregarPost(Request $request, $id_prestamo)
    {
        $fecha = $request->input("fecha");
        $num_abono = $request->input("num_abono");
        $monto_capital = $request->input("monto_capital");
        $monto_interes = $request->input("monto_interes");
        $monto_cobrado = $request->input("monto_cobrado");
        $saldo_pendiente = $request->input("saldo_pendiente");
        $fk_id_prestamo = $id_prestamo;

        $abono = new Abono();
        $abono->fecha = $fecha;
        $abono->num_abono = $num_abono;
        $abono->monto_capital = $monto_capital;
        $abono->monto_interes = $monto_interes;
        $abono->monto_cobrado = $monto_cobrado;
        $abono->saldo_pendiente = $saldo_pendiente;
        $abono->fk_id_prestamo = $id_prestamo;
        
        $abono->save();

        $prestamo = Prestamo::find($fk_id_prestamo);
        
        $prestamo->saldo_actual=$saldo_pendiente;
        if ($saldo_pendiente < 0.01) {
            $prestamo->estado = "CONCLUIDO"; // Marcar como pagado si el saldo llega a 0
        }
    
        $prestamo->save();
    
        return redirect("/prestamos/{$fk_id_prestamo}/abonos");
    }
    // Método para obtener los préstamos asociados a un empleado específico
    public function empleadosPrestamosGet(Request $request, $id_empleado): View
    {
        $empleado = Empleado::find($id_empleado);

        $prestamos = Prestamo::where("prestamo.fk_id_empleado", $id_empleado)->get();

        return view('movimientos.empleadosPrestamosGet', [
            "empleado" => $empleado,
            'prestamos' => $prestamos,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos")
            ]
        ]);
    }

    

    /*public function abonosAgregarPost(Request $request)
    {
        
        $fk_id_prestamo = $request->input("fk_id_prestamo");
        $num_abono = $request->input("num_abono");
        $fecha = $request->input("fecha");
        $monto_capital = $request->input("monto_capital");
        $monto_interes = $request->input("monto_interes");
        $monto_cobrado = $request->input("monto_cobrado");
        $saldo_pendiente = $request->input("saldo_pendiente");
    
        // Crear el nuevo abono
        $abono = new Abono([
            "fk_id_prestamo" => $fk_id_prestamo,
            "num_abono" => $num_abono,
            "fecha" => $fecha,
            "monto_capital" => $monto_capital,
            "monto_interes" => $monto_interes,
            "monto_cobrado" => $monto_cobrado,
            "saldo_pendiente" => $saldo_pendiente,
        ]);
    
        $abono->save();
    
        // Buscar el préstamo con la clave primaria correcta
        $prestamo = Prestamo::find($fk_id_prestamo);
    
       // if (!$prestamo) {
         //   return back()->withErrors("No se encontró el préstamo con ID: $fk_id_prestamo");
        //}
        
        
        
        $prestamo->saldo_actual=$saldo_pendiente;
        if ($saldo_pendiente < 0.01) {
            $prestamo->estado = "CONCLUIDO"; // Marcar como pagado si el saldo llega a 0
        }
    
        $prestamo->save();
    
        return redirect("/prestamos/{$fk_id_prestamo}/abonos");
    
    }
    */

}

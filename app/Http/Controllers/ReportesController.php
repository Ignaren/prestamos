<?php
namespace App\Http\Controllers;
use App\Models\Abono;
use App\Models\Prestamo;
use DateTime;
use Francerz\PowerData\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportesController extends Controller
{
    public function indexGet(Request $request)
    {
        return view("reportes.indexGet", [
            "breadcrumbs"=>[
                "Inicio"=>url("/"),
                "Reportes"=>url("/reportes/prestamos-activos")
            ]
        ]);
    }

    public function prestamosActivosGet(Request $request)
    {
        $fecha=Carbon::now()->format("Y-m-d");//*Carbon Fecha actual en formato de texto
        $fecha=$request->query("fecha",$fecha);
        $prestamos=Prestamo::join("empleado","empleado.id_empleado","=","prestamo.fk_id_empleado")
        ->leftJoin("abono","abono.fk_id_prestamo","=","prestamo.id_prestamo")
        ->select("prestamo.id_prestamo","empleado.nombre","prestamo.monto")
        ->selectRaw("SUM(abono.monto_capital) AS total_capital")
        ->selectRaw("SUM(abono.monto_interes) AS total_interes")
        ->selectRaw("SUM(abono.monto_cobrado) AS total_cobrado")
        ->groupBy("prestamo.id_prestamo","empleado.nombre","prestamo.monto")
        ->where("prestamo.fecha_ini_desc","<=",$fecha)
        ->where("prestamo.fecha_fin_desc",">=",$fecha)
        ->get()->all();
        //*var_dump($prestamos);
        return view("/reportes/prestamosActivosGet", [
            "fecha"=>$fecha,
            "prestamos"=>$prestamos,
            "breadcrumbs"=>[
                "Inicio"=>url("/"),
                "Reportes"=>url("/reportes/prestamos-activos")
            ]
        ]);
    }

    public function matrizAbonosGet(Request $request)
    {
        // Obtener fechas desde la URL o establecer valores predeterminados
        $fecha_ini_desc = $request->query("fecha_inicio", Carbon::now()->format("Y-01-01"));
        $fecha_fin_desc = $request->query("fecha_fin", Carbon::now()->format("Y-12-31"));

        // Consulta con filtro de fechas
        $query = Abono::join("prestamo", "prestamo.id_prestamo", "=", "abono.fk_id_prestamo")
            ->join("empleado", "empleado.id_empleado", "=", "prestamo.fk_id_empleado")
            ->select("prestamo.id_prestamo", "empleado.nombre", "abono.monto_cobrado", "abono.fecha")
            ->orderBy("abono.fecha");

        // Aplicar filtro de fechas
        $query->whereBetween("abono.fecha", [$fecha_ini_desc, $fecha_fin_desc]);

        $abonos = $query->get()->toArray();

        // Convertir fecha a formato Año-Mes para agrupar
        foreach ($abonos as &$abono) {
            $abono["fecha"] = (new DateTime($abono["fecha"]))->format("Y-m");
        }

        // Agrupar los datos para la tabla (Power-Data Index)
        $abonosIndex = new Index($abonos, ["id_prestamo", "fecha"]);

        return view("/reportes/matrizAbonosGet", [
            "abonosIndex" => $abonosIndex,
            "fecha_inicio" => $fecha_ini_desc,
            "fecha_fin" => $fecha_fin_desc,
            "breadcrumbs" => []
        ]);
    }


    
}
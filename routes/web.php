<?php

use App\Http\Controllers\CatalagosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home',["breadcrumbs" =>[]]);
    });
////Catalogos controller
Route::get ("catalogos/puestos", [CatalagosController::class, "puestosGet"]);
Route::get ("catalogos/empleados", [CatalagosController::class, "empleadosGet"]);

Route::get ("catalogos/puestos/agregar",[CatalagosController::class, "puestosAgregarGet"]);
Route::post ("catalogos/puestos/agregar",[CatalagosController::class, "puestosAgregarPost"]);

Route::get ("catalogos/empleados/agregar",[CatalagosController::class, "empleadosAgregarGet"]);
Route::post ("catalogos/empleados/agregar",[CatalagosController::class, "empleadosAgregarPost"]);

Route::get ("catalogos/empleados/{id_empleado}/puestos",[CatalagosController::class, "empleadosPuestosGet"])->where("id","[0-9]+");
Route::get ("catalogos/empleados/{id_empleado}/puestos/cambiar",[CatalagosController::class, "empleadosPuestosCambiarGet"])->where("id","[0-9]+");
Route::post ("catalogos/empleados/{id_empleado}/puestos/cambiar",[CatalagosController::class, "empleadosPuestosCambiarPost"])->where("id","[0-9]+");
/////Movimientos controller
Route::get ("/movimientos/prestamos",[MovimientosController::class, "prestamosGet"]);
Route::get ("/movimientos/prestamos/agregar",[MovimientosController::class, "prestamosAgregarGet"]);
Route::post ("/movimientos/prestamos/agregar",[MovimientosController::class, "prestamosAgregarPost"]);

Route::get("/catalogos/{id}/prestamos", [MovimientosController::class, "empleadosPrestamosGet"])->where("id", "[0-9]+");

Route::get ("/prestamos/{prest}/abonos",[MovimientosController::class,"abonosGet"]) ->where ("prest","\\d+");
Route::get("/prestamos/{prest}/abonos/agregar", [MovimientosController::class, "abonosAgregarGet"])->where("prest", "\\d+");
Route::post("/prestamos/{prest}/abonos/agregar", [MovimientosController::class, "abonosAgregarPost"])->where("prest", "\\d+");

////Reportes controller
Route::get("/reportes",[ReportesController::class,"indexGet"]);
Route::get("/reportes/prestamos-activos",[ReportesController::class,"prestamosActivosGet"]);
Route::get("/reportes/matriz-abonos",[ReportesController::class,"matrizAbonosGet"]);

// Autenticacion
Route::get("/login", [LoginController::class, 'showLoginForm'])->name('login');
Route::post("/login", [LoginController::class, 'login']);
Route::post("/logout", [LoginController::class, 'logout'])->name('logout');
//Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
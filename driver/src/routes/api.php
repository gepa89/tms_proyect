<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/drivers', [DriverController::class, 'index']); // Obtener todos los drivers
Route::post('/drivers', [DriverController::class, 'store']); // Crear un nuevo driver
Route::get('/drivers/{id}', [DriverController::class, 'show']); // Obtener un driver específico
Route::put('/drivers/{id}', [DriverController::class, 'update']); // Actualizar un driver
Route::delete('/drivers/{id}', [DriverController::class, 'destroy']); // Eliminar un driver


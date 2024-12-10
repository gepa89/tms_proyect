<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'Logged out successfully']);
});

// Obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('/users/me', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/tokens', function (Request $request) {
    return $request->user()->tokens;
});

// Rutas protegidas con autenticación para usuarios
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    // Asignar rol a un usuario
    Route::post('/users/{userId}/assign-role', [RoleController::class, 'assignRole']);

    // Remover rol de un usuario
    Route::post('/users/{userId}/remove-role', [RoleController::class, 'removeRole']);
});
Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {
    // Rutas accesibles solo para administradores
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users/{id}', [UserController::class, 'update']);
});
Route::get('/test', function () {
    return response()->json(['message' => 'Funciona correctamente']);
});
Route::get('/simple-test', function () {
    return response()->json(['status' => 'OK']);
});


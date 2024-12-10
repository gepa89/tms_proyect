<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verificar si el usuario tiene el rol adecuado
        if (!$user || !$user->roles->contains('name', $role)) {
            return response()->json(['message' => 'No tienes permiso para acceder a esta ruta.'], 403);
        }

        return $next($request);
    }
}


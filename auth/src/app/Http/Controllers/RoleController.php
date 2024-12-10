<?php 
namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    // Asignar un rol a un usuario por ID de rol
    public function assignRole(Request $request, $userId)
    {
        // Validar que el campo 'role_id' esté presente
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id' // Asegurar que el rol exista
        ]);

        try {
            $user = User::findOrFail($userId); // Encontrar el usuario
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        try {
            // Buscar el rol por ID
            $role = Role::findOrFail($request->role_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ], 404);
        }

        // Asignar el rol al usuario
        $user->assignRole($role);

        return response()->json([
            'status' => 'success',
            'message' => 'Role assigned successfully',
        ], 200);
    }

    // Eliminar un rol de un usuario por ID de rol
    public function removeRole(Request $request, $userId)
    {
        // Validar que el campo 'role_id' esté presente
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id' // Asegurar que el rol exista
        ]);

        try {
            $user = User::findOrFail($userId); // Encontrar el usuario
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        try {
            // Buscar el rol por ID
            $role = Role::findOrFail($request->role_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role not found'
            ], 404);
        }

        // Eliminar el rol del usuario
        $user->removeRole($role);

        return response()->json([
            'status' => 'success',
            'message' => 'Role removed successfully',
        ], 200);
    }
}


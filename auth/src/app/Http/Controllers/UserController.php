<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        $users = User::all();

        // Incluir los roles para cada usuario
        foreach ($users as $user) {
            $user->roles = $user->getRoleNames(); // Agrega los roles
        }

        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    // Mostrar un usuario por ID
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->roles = $user->getRoleNames(); // Incluir los roles del usuario

            return response()->json([
                'status' => 'success',
                'data' => $user
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404); // Código 404 si no se encuentra el usuario
        }
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        // Creación del usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hashea el password
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user
        ], 201); // Código 201 para creación exitosa
    }

    // Actualizar un usuario existente
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Validación de los datos a actualizar (opcional)
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id, // Ignora el email actual del usuario
                'password' => 'sometimes|nullable|string|min:8'
            ]);

            // Actualizar los datos del usuario
            $user->update($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user
            ], 200); // Código 200 para éxito

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }
}


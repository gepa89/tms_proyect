<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VehicleController extends Controller
{
    // Listar todos los vehículos
    public function index()
    {
        return response()->json(Vehicle::all(), 200);
    }

    // Crear un nuevo vehículo
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'license_plate' => 'required|unique:vehicles|max:10',
                'model' => 'required',
                'make' => 'required',
                'year' => 'required|integer',
            ]);

            $vehicle = Vehicle::create($validatedData);

            return response()->json([
                'status' => 'success',
                'data' => $vehicle
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Obtener un vehículo por ID
    public function show($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $vehicle
        ], 200);
    }

    // Actualizar un vehículo
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        try {
            $validatedData = $request->validate([
                'license_plate' => 'required|max:10|unique:vehicles,license_plate,' . $vehicle->id,
                'model' => 'required',
                'make' => 'required',
                'year' => 'required|integer',
            ]);

            $vehicle->update($validatedData);

            return response()->json([
                'status' => 'success',
                'data' => $vehicle
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Eliminar un vehículo
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not found'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle deleted successfully'
        ], 204);
    }
}


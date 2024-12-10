<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        return response()->json(Driver::all(), 200); // Devuelve todos los conductores
    }

    public function store(Request $request)
    {
        $driver = Driver::create($request->all()); // Crea un nuevo conductor
        return response()->json($driver, 201);
    }

    public function show($id)
    {
        $driver = Driver::find($id); // Encuentra un conductor por ID

        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        return response()->json($driver, 200);
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $driver->update($request->all());
        return response()->json($driver, 200);
    }

    public function destroy($id)
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json(['message' => 'Driver not found'], 404);
        }

        $driver->delete();
        return response()->json(['message' => 'Driver deleted'], 200);
    }
}


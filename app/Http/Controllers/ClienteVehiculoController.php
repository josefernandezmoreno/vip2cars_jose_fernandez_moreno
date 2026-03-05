<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteVehiculo;
use App\Models\Cliente;
use App\Models\Vehiculo;

class ClienteVehiculoController extends Controller
{
    

    public function index(Request $request)
{
    // Eager loading de cliente y vehículo
    $query = ClienteVehiculo::with(['cliente', 'vehiculo']);

    // Definir la variable $search por defecto
    $search = $request->input('search', '');

    // Búsqueda
    if (!empty($search)) {
        $query->whereHas('cliente', function ($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('apellidos', 'like', "%{$search}%")
              ->orWhere('documento', 'like', "%{$search}%");
        })
        ->orWhereHas('vehiculo', function ($q) use ($search) {
            $q->where('placa', 'like', "%{$search}%")
              ->orWhere('marca', 'like', "%{$search}%")
              ->orWhere('modelo', 'like', "%{$search}%");
        })
        ->orWhere('observaciones', 'like', "%{$search}%");
    }

    // Ordenamiento por defecto
    $sort = $request->input('sort', 'id');
    $direction = $request->input('direction', 'desc');

    $query->orderBy($sort, $direction);

    // Paginación
    $registros = $query->paginate(10)->withQueryString();

    // Cargar clientes y vehículos para los dropdowns del modal
    $clientes = Cliente::all();
    $vehiculos = Vehiculo::all();

    return view('cliente_vehiculo.index', compact('registros', 'clientes', 'vehiculos', 'sort', 'direction', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,idCliente',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $registro = ClienteVehiculo::create([
            'cliente_id' => $request->cliente_id,
            'vehiculo_id' => $request->vehiculo_id,
            'observaciones' => $request->observaciones,
        ]);

        return response()->json([
            'success' => true,
            'registro' => $registro,
        ]);
    }

    public function destroy($id)
    {
        $registro = ClienteVehiculo::findOrFail($id);
        $registro->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'cliente_id' => 'required|exists:clientes,idCliente',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        // Buscar el registro
        $registro = ClienteVehiculo::find($id);

        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado.'
            ], 404);
        }

        // Actualizar datos
        $registro->cliente_id = $request->cliente_id;
        $registro->vehiculo_id = $request->vehiculo_id;
        $registro->observaciones = $request->observaciones;
        $registro->save();

        return response()->json([
            'success' => true,
            'message' => 'Registro actualizado correctamente.',
            'data' => $registro
        ]);
    }


}

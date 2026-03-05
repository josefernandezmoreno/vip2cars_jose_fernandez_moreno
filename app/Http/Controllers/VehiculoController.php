<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vehiculo::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('placa', 'like', "%$search%")
                ->orWhere('marca', 'like', "%$search%")
                ->orWhere('modelo', 'like', "%$search%")
                ->orWhere('anio_fabricacion', 'like', "%$search%");
        }

        // Ordenamiento
        $sort = $request->input('sort', 'id'); // columna por defecto
        $placa = $request->input('placa', 'asc'); // asc o desc
        $query->orderBy($sort, $placa);

        // Paginación
        $vehiculos = $query->paginate(10)->withQueryString();

        return view('vehiculos.index', compact('vehiculos', 'sort', 'placa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Validación
        $request->validate([
            "placa" => "required|string|max:10|unique:vehiculos,placa",
            "marca" => "required|string|max:50",
            "modelo" => "required|string|max:50",
            "anio_fabricacion" => "required|digits:4",
        ]);

        // Crear vehículo
        $vehiculo = Vehiculo::create([
            "placa" => $request->placa,
            "marca" => $request->marca,
            "modelo" => $request->modelo,
            "anio_fabricacion" => $request->anio_fabricacion,
        ]);

        return response()->json([
            "success" => true,
            "vehiculo" => $vehiculo
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            "placa" => "required|string|max:10",
            "marca" => "required|string|max:50",
            "modelo" => "required|string|max:50",
            "anio_fabricacion" => "required|digits:4",
        ]);

        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update($request->all());

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();

        return response()->json(['success' => true]);
    }
}

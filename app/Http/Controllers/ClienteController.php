<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

  

    public function index(Request $request)
    {
        // $clientes = Cliente::all();

        // return view('clientes.index', compact('clientes'));

        $query = Cliente::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', "%$search%")
                ->orWhere('apellidos', 'like', "%$search%")
                ->orWhere('documento', 'like', "%$search%")
                ->orWhere('correo', 'like', "%$search%")
                ->orWhere('telefono', 'like', "%$search%");
        }

        // Ordenamiento
        $sort = $request->input('sort', 'idCliente'); // columna por defecto
        $direction = $request->input('direction', 'asc'); // asc o desc
        $query->orderBy($sort, $direction);

        // Paginación
        $clientes = $query->paginate(10)->withQueryString();

        return view('clientes.index', compact('clientes', 'sort', 'direction'));
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
        //dd($request->all());

         $request->validate([
        "nombre" => "required|string|max:100",
        "apellidos" => "required|string|max:100",
        "documento" => "required|digits:8|unique:clientes,documento",
        "correo" => "required|email|unique:clientes,correo",
        "telefono" => "required|digits:9"
        ]);

        //Cliente::create($request->all());

        $cliente = Cliente::create([
            "nombre" => $request->nombre,
            "apellidos" => $request->apellidos,
            "documento" => $request->documento,
            "correo" => $request->correo,
            "telefono" => $request->telefono
        ]);

        return response()->json([
        "success" => true,
        "cliente" => $cliente
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'documento' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(['success' => true]);
    }
}

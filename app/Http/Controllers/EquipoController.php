<?php

namespace App\Http\Controllers;

use App\Models\equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipoAll = equipo::where('estado', 'V')
        // ->orderBy('nombre_completo')
        ->get();
        // return response()->json($equipoAll);
        return $equipoAll;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // 1. Recolectar datos con un valor por defecto para el estado
        $data = $request->all();
        $data['estado'] = $request->input('estado', 'V'); // Si no envían estado, pone "A"
        $data['estado_campeonato'] = $request->input('estado_campeonato', 'A'); // Si no envían estado_campeonato, pone "V"

        // 2. Crear el registro en la DB
        try {
            $nuevoEquipo = equipo::create($data);

            return response()->json([
                'mensaje' => 'Equipo creado con éxito',
                'data' => $nuevoEquipo
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el equipo',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(equipo $equipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(equipo $equipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $equipo_id)
    {
        try {
            $equipo = equipo::find($equipo_id); // Buscamos con el parámetro de la URL

            if (!$equipo) {
                return response()->json(['error' => 'Equipo no encontrado'], 404);
            }

            $equipo->update($request->all());

            return response()->json([
                'mensaje' => 'Equipo actualizado con éxito',
                'data' => $equipo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar el equipo actual',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(equipo $equipo, $equipo_id)
    {
        try {
            // 1. Buscar el equipo por el ID de la URL
            $equipo = equipo::find($equipo_id);
var_dump($equipo);
            // 2. Verificar si existe
            if (!$equipo) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'El equipo que intenta eliminar no existe'
                ], 404);
            }

            // 3. Borrado Lógico: Cambiamos el estado_campeonato a 'A'
            // También podrías cambiar el 'estado' a 'I' (Inactivo) si gustas
            $equipo->update([
                'estado_campeonato' => 'A',
                // 'estado'           => 'I'
            ]);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Equipo eliminado correctamente (lógicamente)',
                'data' => $equipo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo eliminar el equipo',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }
}

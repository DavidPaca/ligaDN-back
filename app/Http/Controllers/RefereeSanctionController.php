<?php

namespace App\Http\Controllers;

use App\Models\referee_sanction;
use Illuminate\Http\Request;

class RefereeSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referee_sanctionAll = referee_sanction::where('status', 'V')
        ->get();   
        return $referee_sanctionAll;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request)
    {
        $data = $request->all();
        $data['status'] = $request->input('status', 'V'); // Si no envían estado, pone "A"

        try {
            $nuevoRefereeSanction = referee_sanction::create($data);

            return response()->json([
                'mensaje' => 'Referee Sanction creado con éxito',
                'data' => $nuevoRefereeSanction
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el referee sanction',
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
    public function show(referee_sanction $referee_sanction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(referee_sanction $referee_sanction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $referee_sanction_id)
    {
        try {
            $referee_sanction = referee_sanction::find($referee_sanction_id); // Buscamos con el parámetro de la URL

            if (!$referee_sanction) {
                return response()->json(['error' => 'Referee Sanction no encontrado'], 404);
            }

            $referee_sanction->update($request->all());

            return response()->json([
                'mensaje' => 'Referee Sanction actualizado con éxito',
                'data' => $referee_sanction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar el referee sanction actual',
                'detalles' => $e->getMessage()
            ], 500);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($referee_sanction_id)
    {
        try {
            // 1. Buscar el referee sanction por el ID de la URL
            $referee_sanction = referee_sanction::find($referee_sanction_id);
            // 2. Verificar si existe
            if (!$referee_sanction) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'El referee sanction que intenta eliminar no existe'
                ], 404);
            }

            // 3. Borrado Lógico: Cambiamos el estado_campeonato a 'A'
            // También podrías cambiar el 'estado' a 'I' (Inactivo) si gustas
            $referee_sanction->update([
                'status' => 'E',
            ]);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Referee Sanction eliminado correctamente (lógicamente)',
                'data' => $referee_sanction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo eliminar el referee sanction',
                'detalles' => $e->getMessage()
            ], 500);
        }   
    }
}

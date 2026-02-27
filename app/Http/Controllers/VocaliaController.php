<?php

namespace App\Http\Controllers;

use App\Models\vocalia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VocaliaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vocaliaAll = vocalia::where('status', 'V')
            ->get();
        return $vocaliaAll;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // 1. Recolectar datos con un valor por defecto para el estado
        $data = $request->all();
        $data['status'] = $request->input('status', 'V'); // Si no envían estado, pone "A"
        // GUARDAR FECHA ACTUAL: 'now()' genera la fecha y hora actual automáticamente
        $data['date_vocalia'] = now()->format('Y-m-d');
        // 2. Crear el registro en la DB
        try {
            $nuevoVocalia = vocalia::create($data);

            return response()->json([
                'mensaje' => 'Vocalia creado con éxito',
                'data' => $nuevoVocalia
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear la vocalia',
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
    public function show(vocalia $vocalia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(vocalia $vocalia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $vocalia_id)
    {
        try {
            $vocalia = vocalia::find($vocalia_id); // Buscamos con el parámetro de la URL

            if (!$vocalia) {
                return response()->json(['error' => 'Vocalia no encontrado'], 404);
            }

            $vocalia->update($request->all());

            return response()->json([
                'mensaje' => 'Vocalia actualizado con éxito',
                'data' => $vocalia
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar la vocalia actual',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($vocalia_id)
    {
        try {
            // 1. Buscar el vocalia por el ID de la URL
            $vocalia = vocalia::find($vocalia_id);
            // 2. Verificar si existe
            if (!$vocalia) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'La vocalia que intenta eliminar no existe'
                ], 404);
            }

            // 3. Borrado Lógico: Cambiamos el estado_campeonato a 'A'
            // También podrías cambiar el 'estado' a 'I' (Inactivo) si gustas
            $vocalia->update([
                'status' => 'E',
            ]);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Vocalia eliminado correctamente (lógicamente)',
                'data' => $vocalia
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo eliminar la vocalia',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }
}

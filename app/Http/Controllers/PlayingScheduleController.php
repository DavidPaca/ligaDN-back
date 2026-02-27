<?php

namespace App\Http\Controllers;

use App\Models\playing_schedule;
use Illuminate\Http\Request;

class PlayingScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playing_scheduleAll = playing_schedule::where('status', 'V')
        ->get();
        return $playing_scheduleAll;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request)
    {
        $data = $request->all();
        $data['status'] = $request->input('status', 'V'); // Si no envían estado, pone "A"

        try {
            $nuevoPlayingSchedule = playing_schedule::create($data);

            return response()->json([
                'mensaje' => 'Playing Schedule creado con éxito',
                'data' => $nuevoPlayingSchedule
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el playing schedule',
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
    public function show(playing_schedule $playing_schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(playing_schedule $playing_schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $playing_schedule_id)
    {
        try {
            $playing_schedule = playing_schedule::find($playing_schedule_id); // Buscamos con el parámetro de la URL

            if (!$playing_schedule) {
                return response()->json(['error' => 'Playing Schedule no encontrado'], 404);
            }

            $playing_schedule->update($request->all());

            return response()->json([
                'mensaje' => 'Playing Schedule actualizado con éxito',
                'data' => $playing_schedule
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar el playing schedule actual',
                'detalles' => $e->getMessage()
            ], 500);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $playing_schedule_id)
    {
        try {
            // 1. Buscar el playing schedule por el ID de la URL
            $playing_schedule = playing_schedule::find($playing_schedule_id);
            // 2. Verificar si existe
            if (!$playing_schedule) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'El playing schedule que intenta eliminar no existe'
                ], 404);
            }

            // 3. Borrado Lógico: Cambiamos el estado_campeonato a 'A'
            // También podrías cambiar el 'estado' a 'I' (Inactivo) si gustas
            $playing_schedule->update([
                'status' => 'E',
            ]);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Playing Schedule eliminado correctamente (lógicamente)',
                'data' => $playing_schedule
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo eliminar el playing schedule',
                'detalles' => $e->getMessage()
            ], 500);
        }   
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos jugadores vigentes con su equipo
        return player::where('status', 'V')
            ->with('equipo')
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['status'] = $request->input('status', 'V');

        try {
            $nuevoPlayer = player::create($data);
            return response()->json([
                'mensaje' => 'Jugador creado', 
                'data' => $nuevoPlayer], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear jugador', 
                'detalles' => $e->getMessage()], 500);
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
    public function show(player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $player_id)
    {
        try {
            $player = player::find($player_id);
            if (!$player) return response()->json(['error' => 'No encontrado'], 404);
            
            $player->update($request->all());
            return response()->json(['mensaje' => 'Actualizado', 'data' => $player], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($player_id)
    {
        try {
            $player = player::find($player_id);
            if (!$player) return response()->json(['error' => 'No existe'], 404);
            $player->update(['status' => 'E']);
            return response()->json(['mensaje' => 'Eliminado lógicamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }
}

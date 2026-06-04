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

        $playerAll = player::where('status', 'V')
            // ->orderBy('nombre_completo')
            ->get();
        // return response()->json($equipoAll);
        return $playerAll;
    }

    public function indexTeam($equipo_id)
    {
        $playerAll = player::where('equipo_id', $equipo_id)
            ->where('status', 'V')
            // ->orderBy('nombre_completo')
            ->get();
        // return response()->json($equipoAll);
        // echo "Soy indexTeam";
        return $playerAll;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // 1. Validar duplicados antes de intentar crear
        $existeCi = Player::where('ci', $request->ci)->exists();

        $existeDorsal = Player::where('equipo_id', $request->equipo_id)
            ->where('shirt_number', $request->shirt_number)
            ->exists();

        if ($existeCi || $existeDorsal) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El jugador ya existe (Cédula o Número de camiseta duplicado en el equipo).'
            ], 400); // Código 400 para errores de validación
        }
        // 2. Si no existe, procedemos a crear
        $data = $request->all();
        $data['status'] = $request->input('status', 'V');
        $data['birthdate'] = now()->format('Y-m-d');

        try {
            $nuevoPlayer = player::create($data);
            return response()->json([
                'mensaje' => 'Jugador creado',
                'data' => $nuevoPlayer
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear jugador',
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

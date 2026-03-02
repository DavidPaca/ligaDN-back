<?php

namespace App\Http\Controllers;

use App\Models\championship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Championship::where('status', 'V')->get();
        return response()->json($data, 200);

        // $championshipAll = Championship::where('status', 'V')
        //     // ->orderBy('nombre_completo')
        //     ->get();
        // // return response()->json($equipoAll);
        // return $championshipAll;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:unique,categories', // Validación del ENUM
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'status_championship' => 'required|string|max:2', // PE, AC, FI
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $championship = new Championship();
        $championship->name = $request->name;
        $championship->type = $request->type;
        $championship->start_date = $request->start_date;
        $championship->end_date = $request->end_date;
        $championship->status_championship = $request->status_championship;
        $championship->status = 'V'; // Vigente por defecto
        $championship->description = $request->description;
        $championship->user_id = auth()->id(); // El admin que lo crea
        $championship->save();

        return response()->json([
            'message' => 'Campeonato creado con éxito',
            'data' => $championship,
            'info' => $request->type == 'categories'
                ? 'Recuerda asignar las categorías correspondientes.'
                : 'Campeonato de tabla única listo.'
        ], 201);
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
    public function show(championship $championship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(championship $championship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $championship_id)
    {
        $championship = Championship::find($championship_id);
        if (!$championship) return response()->json(['message' => 'No encontrado'], 404);

        $championship->update($request->all());
        return response()->json(['message' => 'Actualizado correctamente', 'data' => $championship], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($championship_id)
    {
        $championship = Championship::find($championship_id);
        if (!$championship) return response()->json(['message' => 'No encontrado'], 404);

        $championship->status = 'E'; // No borramos de la DB, solo cambiamos status
        $championship->save();

        return response()->json(['message' => 'Campeonato eliminado (Lógico)'], 200);
    }
}

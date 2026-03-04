<?php

namespace App\Http\Controllers;

use App\Models\matches;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return matches::where('status', 'V')
            ->with(['localTeam', 'visitorTeam', 'championshipCategory.category'])
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
            $nuevoMatch = matches::create($data);
            return response()->json(['mensaje' => 'Partido programado', 'data' => $nuevoMatch], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al programar', 'detalles' => $e->getMessage()], 500);
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
    public function show(matches $matches)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(matches $matches)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $match_id)
    {
        try {
            $match = matches::find($match_id);
            if (!$match) return response()->json(['error' => 'Partido no encontrado'], 404);
            $match->update($request->all());
            return response()->json(['mensaje' => 'Partido actualizado', 'data' => $match], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($match_id)
    {
        try {
            $match = matches::find($match_id);
            if (!$match) return response()->json(['error' => 'No encontrado'], 404);
            $match->update(['status' => 'E']);
            return response()->json(['mensaje' => 'Partido cancelado/eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }
}

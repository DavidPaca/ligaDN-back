<?php

namespace App\Http\Controllers;

use App\Models\match_details;
use Illuminate\Http\Request;

class MatchDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return match_details::where('status', 'V')
            ->with(['player', 'equipo'])
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['status'] = $request->input('status', 'V');
        // Aseguramos que is_own_goal sea 0 por defecto si no viene
        $data['is_own_goal'] = $request->input('is_own_goal', 0);

        try {
            $detalle = match_details::create($data);
            return response()->json(['mensaje' => 'Evento registrado (Gol/Tarjeta)', 'data' => $detalle], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar evento', 'detalles' => $e->getMessage()], 500);
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
    public function show(match_details $match_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(match_details $match_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $match_detail_id)
    {
        try {
            $detalle = match_details::find($match_detail_id);
            if (!$detalle) return response()->json(['error' => 'No encontrado'], 404);
            $detalle->update($request->all());
            return response()->json(['mensaje' => 'Evento corregido', 'data' => $detalle], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar', 'detalles' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($match_detail_id)
    {
        try {
            $detalle = match_details::find($match_detail_id);
            if (!$detalle) return response()->json(['error' => 'No encontrado'], 404);
            $detalle->update(['status' => 'E']);
            return response()->json(['mensaje' => 'Evento eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }
}

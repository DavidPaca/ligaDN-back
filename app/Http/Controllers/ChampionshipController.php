<?php

namespace App\Http\Controllers;

use App\Models\championship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Championship::where('status', 'V')
            ->get();
        return response()->json($data, 200);

        // $championshipAll = Championship::where('status', 'V')
        //     // ->orderBy('nombre_completo')
        //     ->get();
        // // return response()->json($equipoAll);
        // return $championshipAll;
    }

    public function indexChampionshipAC()
    {
        $data = Championship::where('status', 'V')
            ->where('status_championship', 'AC')
            ->get();
        return response()->json($data, 200);
    }

    public function indexChampionshipUnique($championship_id)
    {
        $data = Championship::where('status', 'V')
            ->where('status_championship', 'AC')
            ->where('championship_id', $championship_id)
            ->get();
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();
        // 1. Inyectamos el ID del usuario autenticado (vía Token)
        // Esto es mucho más seguro que recibirlo desde el front
        $data['user_id'] = auth()->id();
        $data['status'] = $request->input('status', 'V');
        $data['status_championship'] = $request->input('status_championship', 'AC');
        $data['created_at'] = now()->format('Y-m-d');
        $data['updated_at'] = now()->format('Y-m-d');

        try {
            $newData = championship::create($data);
            return response()->json([
                'mensaje' => 'Campeonato creado con éxito',
                'data' => $newData
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno',
                'detalles' => $e->getMessage(),
                'datos_recibidos' => $data // Esto te ayudará a ver si user_id es null
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

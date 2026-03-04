<?php

namespace App\Http\Controllers;

use App\Models\championship_teams;
use Illuminate\Http\Request;

class ChampionshipTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos los datos con relaciones para saber qué equipo es y en qué categoría está
        $inscripcionesAll = championship_teams::where('status', 'V')
            ->with(['championship_category.category', 'championship_category.championship', 'equipo'])
            ->get();

        return response()->json($inscripcionesAll);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // 1. Recolectar datos y establecer valores por defecto
        $data = $request->all();
        $data['status'] = $request->input('status', 'V');
        // 2. Crear el registro con manejo de errores
        try {
            // Validamos que los IDs existan en sus respectivas tablas
            $request->validate([
                'championship_category_id' => 'required|exists:championship_categories,championship_category_id',
                'equipo_id'                => 'required|exists:equipos,equipo_id',
            ]);
            $nuevaInscripcion = championship_teams::create($data);
            return response()->json([
                'mensaje' => 'Equipo inscrito en el campeonato con éxito',
                'data' => $nuevaInscripcion
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo inscribir al equipo',
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
    public function show(championship_teams $championship_teams)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(championship_teams $championship_teams)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $championship_team_id)
    {
        try {
            $inscripcion = championship_teams::find($championship_team_id);
            if (!$inscripcion) {
                return response()->json(['error' => 'Inscripción no encontrada'], 404);
            }
            $inscripcion->update($request->all());
            return response()->json([
                'mensaje' => 'Inscripción actualizada con éxito',
                'data' => $inscripcion
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar la inscripción',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($championship_team_id)
    {
        try {
            $inscripcion = championship_teams::find($championship_team_id);

            if (!$inscripcion) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'La inscripción que intenta eliminar no existe'
                ], 404);
            }

            // Borrado Lógico: Cambiamos status a 'E'
            $inscripcion->update([
                'status' => 'E'
            ]);
            return response()->json([
                'status' => 'success',
                'mensaje' => 'Equipo retirado del campeonato (E)',
                'data' => $inscripcion
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo retirar al equipo del campeonato',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }
}

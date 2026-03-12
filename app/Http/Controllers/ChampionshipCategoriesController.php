<?php

namespace App\Http\Controllers;

use App\Models\championship_categories;
use Illuminate\Http\Request;

class ChampionshipCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($championship_id)
    {
        $categoriasAll = championship_categories::join('championships', 'championship_categories.championship_id', '=', 'championships.championship_id')
            ->join('categories', 'championship_categories.category_id', '=', 'categories.category_id')
            ->select(
                'championship_categories.*',
                'categories.*',
                'championships.name as championship_name' // Alias para evitar colisiones
            )
            // Especificamos la tabla en el where para evitar ambigüedad
            ->where('championship_categories.status', 'V')
            ->where('championship_categories.championship_id', $championship_id)    
            ->get();

        return response()->json($categoriasAll);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // echo "<pre>+ $request->all()</pre>";
        // $data = $request->validate([
        //     'championship_id' => 'required|exists:championships,championship_id',
        //     'category_id'     => 'required|exists:categories,category_id',
        //     'max_teams'       => 'required|integer',
        // ]);
        // $item = championship_categories::create(array_merge($data, ['status' => 'V']));
        // return response()->json(['message' => 'Categoría asignada al campeonato', 'data' => $item], 201);

        // 1. Recolectar datos y establecer valores por defecto
        $data = $request->all();
        $data['status'] = $request->input('status', 'V');

        // 2. Crear el registro en la DB con manejo de errores
        try {
            // Validamos para asegurar integridad antes de insertar
            $request->validate([
                'championship_id' => 'required|exists:championships,championship_id',
                'category_id'     => 'required|exists:categories,category_id',
                'max_teams'       => 'required|integer',
            ]);

            $nuevaConfiguracion = championship_categories::create($data);

            return response()->json([
                'mensaje' => 'Categoría asignada al campeonato con éxito',
                'data' => $nuevaConfiguracion
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo asignar la categoría al campeonato',
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
    public function show(championship_categories $championship_categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(championship_categories $championship_categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $championship_category_id)
    {
        // Buscamos el registro por su ID personalizado
        // $item = championship_categories::find($championship_category_id);
        // if (!$item) {
        //     return response()->json(['message' => 'Registro no encontrado'], 404);
        // }
        // // Validamos los datos siguiendo tu estructura de campos
        // $data = $request->validate([
        //     'championship_id' => 'required|exists:championships,championship_id',
        //     'category_id'     => 'required|exists:categories,category_id',
        //     'max_teams'       => 'required|integer',
        //     // 'status'          => 'nullable|string|max:1' // V o E
        // ]);
        // // Actualizamos el registro
        // $item->update($data);
        // return
        //     response()->json([
        //         'message' => 'Configuración de categoría actualizada correctamente',
        //         'data' => $item
        //     ], 200);

        try {
            // Buscamos con el parámetro de la URL y tu ID personalizado
            $item = championship_categories::find($championship_category_id);

            if (!$item) {
                return response()->json(['error' => 'Registro no encontrado'], 404);
            }

            // Actualizamos con los datos recibidos
            $item->update($request->all());

            return response()->json([
                'mensaje' => 'Configuración actualizada con éxito',
                'data' => $item
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar la configuración actual',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($championship_category_id)
    {
        // $item = championship_categories::find($championship_category_id);
        // if (!$item) {
        //     return response()->json(['message' => 'No encontrado'], 404);
        // }
        // $item->status = 'E'; // Eliminación lógica siguiendo tu flujo de equipo
        // $item->save();
        // return response()->json(['message' => 'Categoría desvinculada del campeonato'], 200);

        try {
            // 1. Buscar por el ID personalizado
            $item = championship_categories::find($championship_category_id);

            // 2. Verificar si existe
            if (!$item) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'El registro que intenta eliminar no existe'
                ], 404);
            }
            // 3. Borrado Lógico: Cambiamos el status a 'E' (Eliminado)
            $item->update([
                'status' => 'E'
            ]);
            return response()->json([
                'status' => 'success',
                'mensaje' => 'Categoría desvinculada del campeonato correctamente',
                'data' => $item
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo realizar la eliminación lógica',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }
}

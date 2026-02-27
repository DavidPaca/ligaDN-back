<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryAll = category::where('status', 'V')
        ->get();
        return $categoryAll;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request)
    {
        // 1. Recolectar datos con un valor por defecto para el estado
        $data = $request->all();
        $data['status'] = $request->input('status', 'V'); // Si no envían estado, pone "A"

        // 2. Crear el registro en la DB
        try {
            $nuevoCategory = category::create($data);

            return response()->json([
                'mensaje' => 'Category creado con éxito',
                'data' => $nuevoCategory
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear la category',
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
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $category_id)
    {
        try {
            $category = category::find($category_id); // Buscamos con el parámetro de la URL

            if (!$category) {
                return response()->json(['error' => 'Category no encontrado'], 404);
            }

            $category->update($request->all());

            return response()->json([
                'mensaje' => 'Category actualizado con éxito',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar la category actual',
                'detalles' => $e->getMessage()
            ], 500);
        }       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id)
    {
        try {
            // 1. Buscar el category por el ID de la URL
            $category = category::find($category_id);
            // 2. Verificar si existe
            if (!$category) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'La category que intenta eliminar no existe'
                ], 404);
            }

            // 3. Borrado Lógico: Cambiamos el estado_campeonato a 'A'
            // También podrías cambiar el 'estado' a 'I' (Inactivo) si gustas
            $category->update([
                'status' => 'E',
            ]);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Category eliminado correctamente (lógicamente)',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo eliminar la category',
                'detalles' => $e->getMessage()
            ], 500);
        }       
    }
}

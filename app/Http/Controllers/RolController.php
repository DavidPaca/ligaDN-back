<?php

namespace App\Http\Controllers;

use App\Models\rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rolAll = rol::where('status', 'V')
        // ->orderBy('name')
        ->get();
        // return response()->json($rolAll);
        return $rolAll;

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
            $nuevoRol = rol::create($data);

            return response()->json([
                'mensaje' => 'Rol creado con éxito',
                'data' => $nuevoRol
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo crear el rol',
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
    public function show(rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rol $rol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $rol_id)
    {
        try {
            $rol = rol::find($rol_id); // Buscamos con el parámetro de la URL

            if (!$rol) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }

            $rol->update($request->all());

            return response()->json([
                'mensaje' => 'Rol actualizado con éxito',
                'data' => $rol
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo actualizar el rol actual',
                'detalles' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rol_id)
    {
        try {
            // 1. Buscar el rol por el ID de la URL
            $rol = rol::find($rol_id);
            // 2. Verificar si existe
            if (!$rol) {
                return response()->json([
                    'status' => 'error',
                    'mensaje' => 'El rol que intenta eliminar no existe'
                ], 404);
            }

            // 3. Borrado Lógico: Cambiamos el estado_campeonato a 'A'
            // También podrías cambiar el 'estado' a 'I' (Inactivo) si gustas
            $rol->update([
                'status' => 'E',
            ]);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Rol eliminado correctamente (lógicamente)',
                'data' => $rol
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'No se pudo eliminar el rol',
                'detalles' => $e->getMessage()
            ], 500);
        }   
    }
}

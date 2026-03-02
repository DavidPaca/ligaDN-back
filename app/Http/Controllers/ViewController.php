<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    // Tabla de Posiciones
    public function posiciones()
    {
        $data = DB::table('view_posiciones')->get();
        return response()->json($data);
    }

    // Tabla de Goleadores
    public function goleadores()
    {
        $data = DB::table('view_goleadores')->get();
        return response()->json($data);
    }

    // Tabla de Sancionados
    public function sanciones()
    {
        $data = DB::table('view_sanciones_jugadores')->get();
        return response()->json($data);
    }
}

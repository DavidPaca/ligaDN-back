<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; // Necesario para ejecutar SQL puro
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Limpieza preventiva
        DB::statement("DROP VIEW IF EXISTS view_goleadores");

        // 2. Creación de la lógica de la vista
        DB::statement("
            CREATE VIEW view_goleadores AS
            SELECT 
                p.player_id,
                p.name AS nombre,
                p.last_name AS apellido,
                e.nombre_completo AS equipo,
                COUNT(md.match_detail_id) AS goles_totales
            FROM players p
            JOIN equipos e ON p.equipo_id = e.equipo_id
            JOIN match_details md ON p.player_id = md.player_id
            WHERE md.event_type = 'GOL'  -- Solo contamos goles
              AND md.status = 'V'       -- Solo registros vigentes
              AND p.status = 'V'        -- Solo jugadores vigentes
            GROUP BY p.player_id, p.name, p.last_name, e.nombre_completo
            ORDER BY goles_totales DESC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_goleadores");
    }
};
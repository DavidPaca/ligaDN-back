<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("DROP VIEW IF EXISTS view_sanciones_jugadores");

        DB::statement("
            CREATE VIEW view_sanciones_jugadores AS
            SELECT 
                p.player_id,
                p.name AS nombre,
                p.last_name AS apellido,
                e.nombre_completo AS equipo,
                -- Contamos cuántas amarillas tiene (asumiendo que en referee_sanctions el id 1 es Amarilla)
                SUM(CASE WHEN rs.word_initials = 'T.A' THEN 1 ELSE 0 END) AS total_amarillas,
                -- Contamos cuántas rojas tiene
                SUM(CASE WHEN rs.word_initials = 'T.R' THEN 1 ELSE 0 END) AS total_rojas,
                -- Sumamos el valor total en multas que debe el jugador
                SUM(rs.price) AS total_deuda_economica
            FROM players p
            JOIN equipos e ON p.equipo_id = e.equipo_id
            JOIN match_details md ON p.player_id = md.player_id
            JOIN referee_sanctions rs ON md.referee_sanction_id = rs.referee_sanction_id
            WHERE md.event_type = 'SANCTION'
              AND md.status = 'V'
              AND p.status = 'V'
            GROUP BY p.player_id, p.name, p.last_name, e.nombre_completo
        ");
    }

    public function down(): void {
        DB::statement("DROP VIEW IF EXISTS view_sanciones_jugadores");
    }
};
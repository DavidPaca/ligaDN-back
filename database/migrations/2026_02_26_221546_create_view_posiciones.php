<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("DROP VIEW IF EXISTS view_posiciones");

        DB::statement("
            CREATE VIEW view_posiciones AS
            SELECT 
                equipo_id,
                nombre_equipo,
                COUNT(*) AS PJ,
                SUM(ganado) AS PG,
                SUM(empatado) AS PE,
                SUM(perdido) AS PP,
                SUM(goles_favor) AS GF,
                SUM(goles_contra) AS GC,
                SUM(goles_favor - goles_contra) AS GD,
                SUM(puntos) AS PTS
            FROM (
                -- Lógica para el Equipo LOCAL
                SELECT 
                    m.local_team_id AS equipo_id,
                    e.nombre_completo AS nombre_equipo,
                    (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') AS goles_favor,
                    (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') AS goles_contra,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') > 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') THEN 1 ELSE 0 END AS ganado,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') = 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') THEN 1 ELSE 0 END AS empatado,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') < 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') THEN 1 ELSE 0 END AS perdido,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') > 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') THEN 3
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') = 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') THEN 1
                        ELSE 0 END AS puntos
                FROM matches m
                JOIN equipos e ON m.local_team_id = e.equipo_id
                WHERE m.status = 'V' -- Solo partidos finalizados/vigentes

                UNION ALL

                -- Lógica para el Equipo VISITANTE
                SELECT 
                    m.visitor_team_id AS equipo_id,
                    e.nombre_completo AS nombre_equipo,
                    (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') AS goles_favor,
                    (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') AS goles_contra,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') > 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') THEN 1 ELSE 0 END AS ganado,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') = 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') THEN 1 ELSE 0 END AS empatado,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') < 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') THEN 1 ELSE 0 END AS perdido,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') > 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') THEN 3
                        WHEN (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.visitor_team_id AND event_type = 'GOL' AND status = 'V') = 
                             (SELECT COUNT(*) FROM match_details WHERE match_id = m.match_id AND equipo_id = m.local_team_id AND event_type = 'GOL' AND status = 'V') THEN 1
                        ELSE 0 END AS puntos
                FROM matches m
                JOIN equipos e ON m.visitor_team_id = e.equipo_id
                WHERE m.status = 'V'
            ) AS resultados_acumulados
            GROUP BY equipo_id, nombre_equipo
            ORDER BY PTS DESC, GD DESC, GF DESC; -- Criterios de desempate estándar
        ");
    }

    public function down(): void {
        DB::statement("DROP VIEW IF EXISTS view_posiciones");
    }
};
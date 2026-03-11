<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /////////// USUARIOS ///////////
        $user = new \App\Models\User;
        $user->ci = "0000000000";
        $user->name = "Liga Deportiva Barrial";
        $user->last_name = "Divino Niño";
        $user->birthdate = "1992-06-22";
        $user->country = "Ecuador";
        $user->city = "Quito";
        $user->cellphone = "0984111628";
        $user->rol = "Administrador";
        $user->img = "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Ciclon.svg/1200px-Ciclon.svg.png";
        $user->email = "ligadeportivadivinonino2025@gmail.com";
        $user->password = bcrypt('123456789');
        $user->save();

        ////////// CHAMPIONSHIPS (Lo movemos arriba) //////////
        $championship = new \App\Models\Championship;
        $championship->name = "Campeonato Apertura 2026";
        $championship->type = "categories";
        $championship->start_date = "2026-02-01";
        $championship->end_date = "2026-12-01";
        $championship->status_championship = "AC";
        $championship->status = "V";
        $championship->save();

        ////////// CATEGORIAS (Ahora ya tenemos el championship_id) //////////
        $category = new \App\Models\Category;
        // $category->championship_id = $championship->championship_id; // <--- SOLUCIÓN AL ERROR
        $category->details = "Senior";
        $category->gender = "M";
        $category->description = "La categoria Senior es una categoría de nivel superior.";
        $category->status = "V";
        $category->save();

        ////////// EQUIPOS //////////
        $equipo = new \App\Models\Equipo;
        $equipo->nombre_completo = "Club Atlético Ciclón";
        $equipo->nombre_corto = "C.A. Ciclón";
        $equipo->abrebiatura = "AC";
        $equipo->descripcion = "Club deportivo de Ciudad de México.";
        $equipo->imagen = "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Ciclon.svg/1200px-Ciclon.svg.png";
        $equipo->estado = "V";
        $equipo->estado_campeonato = "A";
        $equipo->save();
 
        $equipo2 = new \App\Models\Equipo;
        $equipo2->nombre_completo = "Real Madrid F.C.";
        $equipo2->nombre_corto = "Real Madrid";
        $equipo2->abrebiatura = "RM";
        $equipo2->descripcion = "Club merengue de la liga barrial.";
        $equipo2->imagen = "https://upload.wikimedia.org/wikipedia/en/thumb/5/56/Real_Madrid_CF.svg/1200px-Real_Madrid_CF.svg.png";
        $equipo2->estado = "V";
        $equipo2->estado_campeonato = "A";
        $equipo2->save();

        ////////// ROL //////////
        $rol = new \App\Models\Rol;
        $rol->name = "Administrador";
        $rol->description = "Rol con funciones totales.";
        $rol->status = "V";
        $rol->save();

        ////////// VOCALIA //////////
        $vocalia = new \App\Models\Vocalia;
        $vocalia->details = "Vocalia Fecha Nro.01";
        $vocalia->description = "Vocalia de la fecha Nro. 01";
        $vocalia->price = 10;
        $vocalia->date_vacalia = "2025-08-31";
        $vocalia->status = "V";
        $vocalia->save();

        ////////// PLAYING SCHEDULES //////////
        $playing_schedule = new \App\Models\playing_schedule;
        $playing_schedule->details = "08h00";
        $playing_schedule->description = "Primer horario";
        $playing_schedule->status = "V";
        $playing_schedule->save();

        ////////// REFEREE SANCTIONS //////////
        $referee_sanction = new \App\Models\referee_sanction;
        $referee_sanction->details = "Tarjeta Amarilla";
        $referee_sanction->word_initials = "T.A.";
        $referee_sanction->description = "Sanción de amonestación.";
        $referee_sanction->price = 0.50;
        $referee_sanction->date_sanction = "2025-08-31";
        $referee_sanction->status = "V";
        $referee_sanction->save();

        ////////// PLAYERS //////////
        $player1 = new \App\Models\Player;
        $player1->equipo_id = $equipo->equipo_id;
        $player1->name = "Romario";
        $player1->last_name = "Ferreira";
        $player1->shirt_number = 10;
        $player1->status = "V";
        $player1->save();

        $player2 = new \App\Models\Player;
        $player2->equipo_id = $equipo2->equipo_id;
        $player2->name = "Gabriel";
        $player2->last_name = "Batistuta";
        $player2->shirt_number = 7;
        $player2->status = "V";
        $player2->save();

        ////////// MATCHES //////////
        $match = new \App\Models\Matches;
        $match->championship_category_id = 1; 
        $match->local_team_id = $equipo->equipo_id;
        $match->visitor_team_id = $equipo2->equipo_id;
        $match->playing_schedule_id = $playing_schedule->playing_schedule_id;
        $match->vocalia_id = $vocalia->vocalia_id;
        $match->match_date = "2026-02-26";
        $match->status = "V";
        $match->save();

        ////////// MATCH DETAILS //////////
        $detail1 = new \App\Models\match_details;
        $detail1->match_id = $match->match_id;
        $detail1->player_id = $player1->player_id;
        $detail1->equipo_id = $equipo->equipo_id;
        $detail1->event_type = 'GOL';
        $detail1->is_own_goal = false;
        $detail1->minute = 10;
        $detail1->period = 1;
        $detail1->status = 'V';
        $detail1->save();

        $detail2 = new \App\Models\match_details;
        $detail2->match_id = $match->match_id;
        $detail2->player_id = $player2->player_id;
        $detail2->equipo_id = $equipo2->equipo_id;
        $detail2->referee_sanction_id = $referee_sanction->referee_sanction_id;
        $detail2->event_type = 'SANCTION';
        $detail2->minute = 30;
        $detail2->period = 1;
        $detail2->status = 'V';
        $detail2->save();

        $detail3 = new \App\Models\match_details;
        $detail3->match_id = $match->match_id;
        $detail3->player_id = $player2->player_id;
        $detail3->equipo_id = $equipo2->equipo_id;
        $detail3->event_type = 'GOL';
        $detail3->is_own_goal = false;
        $detail3->minute = 80;
        $detail3->period = 2;
        $detail3->status = 'V';
        $detail3->save();

        /////////// TOURNAMENT PHASES ///////////
        $tournament_phase = new \App\Models\tournament_phases();
        $tournament_phase->details = "Todos contra todos";
        $tournament_phase->description = "Consiste en que todos los equipos se enfrentan entre si contra todos";
        $tournament_phase->status = "V";
        $tournament_phase->save();

        $tournament_phase = new \App\Models\tournament_phases();
        $tournament_phase->details = "Todos contra todos + Eliminatoria";
        $tournament_phase->description = "Consiste en que todos los equipos se enfrentan entre si contra todos para llagar a las eliminatorias";
        $tournament_phase->status = "V";
        $tournament_phase->save();

        $tournament_phase = new \App\Models\tournament_phases();
        $tournament_phase->details = "Eliminatoria";
        $tournament_phase->description = "Consiste en que los equipos que no pueden enfrentar a todos los equipos se enfrentan a los equipos que pueden enfrentar a todos los equipos";
        $tournament_phase->status = "V";
        $tournament_phase->save();
    }
}
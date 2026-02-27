<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id('match_id');
            $table->unsignedBigInteger('championship_category_id');
            $table->unsignedBigInteger('local_team_id')->nullable();
            $table->unsignedBigInteger('visitor_team_id')->nullable();
            $table->unsignedBigInteger('playing_schedule_id')->nullable();
            $table->unsignedBigInteger('vocalia_id')->nullable();
            $table->unsignedBigInteger('referee_id')->nullable(); // Usuario con rol árbitro
            $table->date('match_date')->nullable();
            $table->string('field_number')->nullable(); // Número de cancha
            $table->text('observations')->nullable(); // El cuadro de "OBSERVACIONES" de tu imagen
            $table->char('status', 2)->default('V'); // V=Vigente, E=Eliminado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};

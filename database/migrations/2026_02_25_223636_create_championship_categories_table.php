<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Esta tabla relaciona un campeonato con sus categorías.
     * Ejemplos:
     *   - Campeonato 2026 → Senior Masculino
     *   - Campeonato 2026 → Senior Femenino
     *   - Campeonato 2026 → Sub 12 Masculino
     */
    public function up(): void
    {
        Schema::create('championship_categories', function (Blueprint $table) {
            $table->id('championship_category_id');
            // Relación con championships
            $table->unsignedBigInteger('championship_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('max_teams')->nullable();
            $table->enum('game_system', ['league', 'playoffs', 'mixed']); // League (Todos contra todos), Playoffs (Eliminatorias), Mixed
            $table->char('status', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('championship_categories');
    }
};
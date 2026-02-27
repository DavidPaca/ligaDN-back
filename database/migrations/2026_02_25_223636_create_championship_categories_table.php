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
            // Relación con categories
            $table->unsignedBigInteger('category_id')->nullable();
            // Número máximo de equipos permitidos en esta categoría (opcional)
            $table->integer('max_teams')->nullable();
            // Estado de esta categoría dentro del campeonato
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
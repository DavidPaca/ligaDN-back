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
        Schema::create('players', function (Blueprint $table) {
            $table->id('player_id');
            $table->foreignId('equipo_id');
            $table->string('ci')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('birthdate')->nullable();
            $table->integer('shirt_number')->nullable();
            $table->string('player_position')->nullable(); // Portero, Defensa, etc.
            $table->boolean('is_captain')->nullable();
            $table->char('status', 2)->nullable(); // V=Vigente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};

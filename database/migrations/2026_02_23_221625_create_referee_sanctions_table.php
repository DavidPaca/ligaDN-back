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
        Schema::create('referee_sanctions', function (Blueprint $table) {
            $table->id('referee_sanction_id');
            $table->string('details')->nullable();
            $table->date('date_sanction')->nullable();
            $table->string('description', 500)->nullable(); // Un poco más de espacio para descripciones
            $table->decimal('price', 10, 2)->nullable();    // Aumentado a 10 por seguridad
            $table->string('word_initials', 10)->nullable(); // Limitado para siglas
            $table->char('status', 2)->nullable();        // Consistente con EquiposPage

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referee_sanctions');
    }
};

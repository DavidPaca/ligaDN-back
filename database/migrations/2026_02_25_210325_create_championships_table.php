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
        Schema::create('championships', function (Blueprint $table) {
            $table->id('championship_id');
            $table->string('name')->nullable();
            // Tipo de campeonato
            $table->enum('type', ['unique', 'categories'])->nullable();
            // Fechas
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            // Imagen y Estado
            $table->string('image')->nullable();
            $table->char('status_championship', 2)->nullable()
                ->comment('PE=Pendiente, AC=Activo, FI=Finalizado, CA=Cancelado');
            $table->string('status')->nullable()
                ->comment('V=Vigente, E=Eliminado');
            // Descripción y Relación
            $table->string('description', 500)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('championships');
    }
};

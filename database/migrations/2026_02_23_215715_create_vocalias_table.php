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
        Schema::create('vocalias', function (Blueprint $table) {
            $table->id('vocalia_id');
            $table->string('details')->nullable();
            $table->string('description', 500)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->date('date_vacalia')->nullable();
            $table->char('status', 2)->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocalias');
    }
};

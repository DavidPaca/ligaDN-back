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
        Schema::create('championship_teams', function (Blueprint $table) {
            $table->id('championship_team_id');
            $table->unsignedBigInteger('championship_category_id')->nullable();
            $table->unsignedBigInteger('equipo_id')->nullable();
            $table->char('status', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('championship_teams');
    }
};

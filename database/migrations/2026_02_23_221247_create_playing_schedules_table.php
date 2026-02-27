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
        Schema::create('playing_schedules', function (Blueprint $table) {
            $table->id('playing_schedule_id');
            $table->string('details')->nullable();
            $table->string('description', 500)->nullable();
            $table->char('status', 2)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playing_schedules');
    }
};

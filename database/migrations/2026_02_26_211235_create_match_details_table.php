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
        Schema::create('match_details', function (Blueprint $table) {
            $table->id('match_detail_id');
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('referee_sanction_id')->nullable();

            $table->enum('event_type', ['GOL', 'SANCTION', 'CAMBIO']);
            $table->integer('minute')->nullable();
            $table->boolean('is_own_goal')->default(false);
            $table->tinyInteger('period')->nullable();
            $table->char('status', 2)->default('V');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_details');
    }
};

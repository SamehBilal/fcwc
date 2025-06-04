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
        Schema::create('games_users', function (Blueprint $table) {
            $table->id();
            $table->string('player_id', 10)->unique();
            $table->foreignId('game_id')->nullable()->index();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->string('score')->default(0);
            $table->unique(['player_id', 'game_id', 'user_id'], 'unique_player_slot');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_users');
    }
};

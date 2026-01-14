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
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('match_id')->constrained('matches')->onDelete('cascade');
            $table->integer('bet_amount');

            // 1 for team_1, 2 for team_2, 0 for draw
            $table->integer('predicted_winner');
            $table->boolean('is_settled')->default(false);
            $table->integer('payout')->nullable();
            $table->timestamps();

            // Ensure a user can only bet once per match
            $table->unique(['user_id', 'match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};

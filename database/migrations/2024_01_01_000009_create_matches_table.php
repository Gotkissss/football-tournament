<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('home_team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('away_team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('stadium_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('match_date');
            $table->enum('stage', [
                'group_stage', 'round_of_16', 'quarterfinal',
                'semifinal', 'third_place', 'final'
            ])->default('group_stage');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->integer('home_score_extra')->nullable(); // tiempo extra
            $table->integer('away_score_extra')->nullable();
            $table->integer('home_score_penalties')->nullable();
            $table->integer('away_score_penalties')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'finished', 'postponed'])->default('scheduled');
            $table->integer('attendance')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};

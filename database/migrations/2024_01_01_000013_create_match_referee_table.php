<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_referee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
            $table->foreignId('referee_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['main', 'assistant', 'fourth', 'var'])->default('main');
            $table->timestamps();

            $table->unique(['match_id', 'referee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_referee');
    }
};

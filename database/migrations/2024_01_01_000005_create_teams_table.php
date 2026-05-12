<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('short_name', 20)->nullable();
            $table->string('crest_url')->nullable();
            $table->string('primary_color', 7)->default('#000000');
            $table->string('secondary_color', 7)->default('#ffffff');
            $table->enum('team_type', ['national', 'club'])->default('national');
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stadium_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};

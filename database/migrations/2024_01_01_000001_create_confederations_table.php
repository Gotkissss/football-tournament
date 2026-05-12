<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('confederations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('acronym', 10)->unique();
            $table->string('region', 100);
            $table->string('logo_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confederations');
    }
};

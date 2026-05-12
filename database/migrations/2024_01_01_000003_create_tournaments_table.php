<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('type', ['world_cup', 'continental', 'club'])->default('world_cup');
            $table->year('edition_year');
            $table->string('host_country', 100)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('logo_url')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('confederation_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};

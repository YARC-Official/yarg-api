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
        Schema::create('song_sources', function (Blueprint $table) {
            $table->id();
            $table->string('source_type')->comment('Enum');
            $table->string('game_type')->comment('Enum');
            $table->string('name');
            $table->string('tags');
            $table->string('icon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_sources');
    }
};

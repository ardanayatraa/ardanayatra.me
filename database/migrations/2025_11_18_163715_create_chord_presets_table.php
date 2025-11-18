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
        Schema::create('chord_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "C", "Am", "G7"
            $table->string('family'); // e.g., "C", "A", "G" (root note)
            $table->string('type')->default('major'); // major, minor, 7, m7, maj7, etc.
            $table->enum('difficulty', ['simple', 'advanced'])->default('simple'); // simple or advanced
            $table->json('fingers'); // [{string: 0, fret: 1}, ...]
            $table->json('open_strings')->nullable(); // [0, 3, 4, 5]
            $table->json('muted_strings')->nullable(); // [5]
            $table->integer('starting_fret')->default(0);
            $table->integer('num_frets')->default(5);
            $table->integer('num_strings')->default(6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chord_presets');
    }
};

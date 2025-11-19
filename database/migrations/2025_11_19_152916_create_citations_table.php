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
        Schema::create('citations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained()->onDelete('cascade');
            $table->string('author'); // Nama penulis
            $table->string('title'); // Judul artikel/buku
            $table->string('source')->nullable(); // Nama jurnal/penerbit
            $table->string('year', 4)->nullable(); // Tahun publikasi
            $table->string('volume')->nullable(); // Volume jurnal
            $table->string('issue')->nullable(); // Issue/nomor
            $table->string('pages')->nullable(); // Halaman
            $table->string('doi')->nullable(); // DOI
            $table->string('url')->nullable(); // URL sumber
            $table->enum('type', ['journal', 'book', 'website', 'conference'])->default('journal');
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citations');
    }
};

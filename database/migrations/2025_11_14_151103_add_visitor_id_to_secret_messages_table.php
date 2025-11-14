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
        Schema::table('secret_messages', function (Blueprint $table) {
            $table->foreignId('visitor_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secret_messages', function (Blueprint $table) {
            $table->dropForeign(['visitor_id']);
            $table->dropColumn('visitor_id');
        });
    }
};

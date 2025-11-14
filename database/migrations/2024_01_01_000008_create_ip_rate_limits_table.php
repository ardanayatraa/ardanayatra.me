<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ip_rate_limits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 100);
            $table->string('action', 100);
            $table->integer('count')->default(0);
            $table->timestamp('last_attempt_at');
            
            $table->unique(['ip_address', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_rate_limits');
    }
};

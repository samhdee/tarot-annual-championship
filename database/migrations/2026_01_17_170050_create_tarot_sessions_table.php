<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tarot_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at')->index();
            $table->timestamp('ended_at')->nullable();
            $table->foreignId('host_id')->index();
            $table->foreignId('winner_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarot_sessions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('game_id')->index();
            $table->foreignId('bid_id')->index();
            $table->boolean('is_dealer')->default(0);
            $table->enum('role', ['taker', 'taker_partner', 'defender'])->index();
            $table->boolean('has_declared_slam')->default(0);
            $table->integer('nb_tricks')->default(0);
            $table->integer('points')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};

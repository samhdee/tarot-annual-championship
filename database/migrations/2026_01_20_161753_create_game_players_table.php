<?php

use App\Enums\BGABids;
use App\Enums\Miseres;
use App\Enums\Poignees;
use App\Models\Game;
use App\Models\HandPlayer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_players', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(Game::class, 'game_id');
            $table->foreignIdFor(HandPlayer::class, 'hand_player_id');
            $table->integer('order');
            $table->enum('bga_bid_id', array_column(BGABids::cases(), 'value'))->nullable();
            $table->enum('role', ['taker', 'taker_partner', 'defender']);
            $table->boolean('has_declared_slam')->nullable();
            $table->enum('misere', array_column(Miseres::cases(), 'name'))->nullable();
            $table->enum('poignee_type', array_column(Poignees::cases(), 'name'))->nullable();
            $table->integer('poignee_nb_atouts')->default(0);
            $table->integer('nb_tricks')->default(0);
            $table->integer('points')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_players');
    }
};

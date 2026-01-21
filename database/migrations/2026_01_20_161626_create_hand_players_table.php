<?php

use App\Models\BgaUserModel;
use App\Models\HandModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hand_players', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(BgaUserModel::class, 'bga_user_id');
            $table->foreignIdFor(HandModel::class, 'hand_id');
            $table->boolean('is_host')->nullable();
            $table->integer('total_points')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hand_players');
    }
};

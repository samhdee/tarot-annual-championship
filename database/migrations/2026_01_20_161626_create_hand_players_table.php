<?php

use App\Models\BgaUser;
use App\Models\Hand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hand_players', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(BgaUser::class, 'bga_user_id');
            $table->foreignIdFor(Hand::class, 'hand_id');
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

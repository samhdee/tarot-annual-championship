<?php

use App\Models\HandModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(HandModel::class, 'hand_id');
            $table->enum('king_colour', ['141', '142', '143', '144']);
            $table->smallInteger('contract_points_diff')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};

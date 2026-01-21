<?php

use App\Models\MeetModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hands', function (Blueprint $table) {
            $table->id();
            $table->string('imported_from', 255)->nullable();
            $table->integer('bga_hand_id', unsigned: true)->nullable();
            $table->foreignIdFor(MeetModel::class, 'meet_id');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hands');
    }
};

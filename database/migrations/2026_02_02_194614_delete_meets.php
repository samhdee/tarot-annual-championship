<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hands', function (Blueprint $table) {
            $table->dropForeign(['meet_id']);
            $table->dropColumn(['meet_id']);
        });

        Schema::dropIfExists('meets');
    }
};

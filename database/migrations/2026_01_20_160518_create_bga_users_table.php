<?php

use App\Models\UserModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bga_users', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(UserModel::class, 'user_id');
            $table->string('bga_username')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bga_users');
    }
};

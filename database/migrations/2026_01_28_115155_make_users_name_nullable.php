<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->removeColumn('username');
            $table->boolean('is_active')->default(0);
        });

        Schema::table('bga_users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
    }
};

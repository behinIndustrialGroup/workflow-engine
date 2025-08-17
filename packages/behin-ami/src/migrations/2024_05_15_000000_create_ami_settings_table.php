<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ami_settings', function (Blueprint $table) {
            $table->id();
            $table->string('host')->default('127.0.0.1');
            $table->integer('port')->default(5038);
            $table->string('username');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ami_settings');
    }
};

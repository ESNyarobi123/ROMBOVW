<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('e.g., Main Village Router');
            $table->string('ip');
            $table->string('username');
            $table->text('password')->comment('Will be encrypted in the database');
            $table->integer('port')->default(8728)->comment('MikroTik API Port');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};

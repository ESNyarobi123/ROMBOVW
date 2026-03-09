<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('e.g., 1 Hour Tsh 500');
            $table->decimal('price', 10, 2);
            $table->integer('time_limit')->comment('Time limit in minutes');
            $table->unsignedBigInteger('bytes_limit')->nullable()->comment('Data limit in bytes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

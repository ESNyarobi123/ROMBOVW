<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('mac_address')->nullable()->comment('Bound dynamically upon hotspot login');
            $table->string('ip_address')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['pending', 'active', 'expired', 'disconnected'])->default('pending');
            $table->string('phone')->nullable()->comment('Phone associated with this voucher');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};

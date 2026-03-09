<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('mpesa_receipt')->unique()->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('phone');
            $table->foreignId('voucher_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->json('callback_data')->nullable()->comment('Store raw M-Pesa response');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

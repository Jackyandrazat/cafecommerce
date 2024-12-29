<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('customer_name'); // Nama Pelanggan
            $table->string('customer_email')->nullable(); // Email Pelanggan
            $table->string('customer_phone')->nullable(); // Nomor Telepon Pelanggan
            $table->decimal('total_price', 15, 2)->default(0); // Total Harga
            $table->enum('status', ['pending', 'paid', 'cancelled', 'expired'])->default('pending'); // Status Pesanan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode promo unik
            $table->enum('type', ['percentage', 'nominal']); // Jenis promo
            $table->decimal('value', 10, 2); // Nilai promo
            $table->dateTime('start_date'); // Tanggal mulai
            $table->dateTime('end_date'); // Tanggal berakhir
            $table->boolean('is_active')->default(true); // Status promo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};

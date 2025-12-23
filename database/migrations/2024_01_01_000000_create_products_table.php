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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');         // Nama: Beetroot
        $table->string('type');         // Tipe: Local Shop, Organic, dll
        $table->string('weight');       // Berat: 500 gm
        $table->decimal('price', 12, 2); // Harga: 17.29 -> Ubah ke 12 digit agar muat jutaan Rupiah
        $table->string('image');        // URL Gambar
        $table->integer('qty')->default(0); // Default qty 0 (untuk logic frontend nanti)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

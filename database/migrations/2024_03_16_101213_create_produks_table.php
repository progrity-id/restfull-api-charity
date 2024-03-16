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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('gambar');
            $table->string('harga');
            $table->string('sn');
            $table->string('stock');
            $table->unsignedBigInteger('id_supplier');
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_supplier')->on('suppliers')->references('id');
            $table->foreign('id_kategori')->on('kategoris')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};

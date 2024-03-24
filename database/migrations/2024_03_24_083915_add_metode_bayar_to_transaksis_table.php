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
        Schema::table('transaksis', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->enum('metode_bayar', ['Cash', 'E-Wallet', 'Transfer'])->default('Cash');
            $table->enum('status', ['Proses', 'Selesai', 'Batal'])->default('Proses')->change();
            //
        });
    }
};

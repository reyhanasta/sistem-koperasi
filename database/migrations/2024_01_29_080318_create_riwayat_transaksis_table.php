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
        Schema::create('riwayat_transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tabungan_id');
            $table->unsignedBigInteger('id_pegawai');
            $table->decimal('nominal', 10, 2);
            $table->decimal('saldo_akhir',10,2);
            $table->enum('type', ['debit', 'kredit','angsuran']);
            $table->timestamps();
            $table->foreign('tabungan_id')->references('id')->on('buku_tabungans');
            $table->foreign('id_pegawai')->references('id')->on('pegawais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_transaksis');
    }
};

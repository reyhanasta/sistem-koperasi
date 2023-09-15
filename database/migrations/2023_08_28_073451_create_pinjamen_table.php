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
        Schema::create('pinjamen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nasabah');
            $table->foreignId('id_pegawai');
            $table->string('kode_pinjaman')->default('P238001');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_persetujuan')->nullable();
            $table->decimal('jumlah_pinjaman', 10, 2);
            $table->string('jenis_pinjaman');
            $table->string('tujuan_pinjaman');
            $table->integer('jangka_waktu'); // dalam bulan
            $table->decimal('bunga', 5, 2)->default(0)->nullable();
            $table->string('status')->default('diajukan');
            $table->string('metode_pembayaran')->default('cash');
            $table->date('tanggal_pelunasan')->nullable();
            $table->decimal('total_pembayaran', 10, 2)->default(0);
            $table->decimal('angsuran', 10, 2)->default(0);
            $table->decimal('sisa_pinjaman', 10, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('id_nasabah')->references('id')->on('nasabahs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamen');
    }
};

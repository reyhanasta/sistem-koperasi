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
            $table->unsignedBigInteger('nasabah_id');
            $table->foreignId('id_pegawai');
            $table->string('kode_pinjaman')->default('P238001');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_persetujuan')->nullable();
            $table->decimal('jumlah_pinjaman', 10, 2);
            $table->string('jenis_pinjaman')->default('usaha');
            $table->string('tujuan_pinjaman')->default('usaha kelontong');
            $table->integer('jangka_waktu'); // dalam bulan
            $table->decimal('bunga', 5, 2)->default(0);
            $table->string('status')->default('Diajukan');
            $table->string('metode_pembayaran')->default('cash');
            $table->date('tanggal_pelunasan')->nullable();
            $table->decimal('total_pembayaran', 10, 2)->default(0);
            $table->decimal('angsuran', 10, 2)->default(0);
            $table->integer('jumlah_angsuran')->default(0); // dalam satuan
            $table->decimal('sisa_pinjaman', 10, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft Delete

            
            // Foreign key constraint
            $table->foreign('nasabah_id')->references('id')->on('nasabahs');
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

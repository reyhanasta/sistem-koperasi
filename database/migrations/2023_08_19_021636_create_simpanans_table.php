<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('simpanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rekening')->constrained('buku_tabungans')->onDelete('cascade');
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('kode_simpanan', 100)->default('KS123456');
            $table->string('type')->default('deposit');
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('saldo_akhir', 15, 2)->default(0);
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft Delete

            // Menambahkan indeks
            $table->index('nasabah_id');
            $table->index('id_rekening');
            $table->index('pegawai_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanans');
    }
};

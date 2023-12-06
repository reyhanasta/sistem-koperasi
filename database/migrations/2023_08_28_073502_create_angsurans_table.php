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
        Schema::create('angsurans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pinjaman');
            $table->unsignedBigInteger('nasabah_id');
            $table->date('tanggal_angsuran');
            $table->decimal('jumlah_angsuran', 10, 2);
            $table->enum('status', ['Lunas', 'Belum Lunas']);
            $table->timestamps();
            $table->softDeletes(); // Soft Delete

            // Foreign key constraint
            $table->foreign('id_pinjaman')->references('id')->on('pinjamen');
            $table->foreign('nasabah_id')->references('id')->on('nasabahs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsurans');
    }
};

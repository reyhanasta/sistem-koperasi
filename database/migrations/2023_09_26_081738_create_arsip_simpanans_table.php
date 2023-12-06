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
        Schema::create('arsip_simpanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nasabah_id');
            $table->date('tanggal_simpanan');
            $table->string('jenis_simpanan');
            $table->decimal('jumlah_simpanan', 10, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('nasabah_id')->references('id')->on('nasabahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_simpanans');
    }
};

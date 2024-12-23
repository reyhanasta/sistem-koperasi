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
            $table->foreignId('id_rekening')->default(1);
            $table->foreignId('nasabah_id')->default(1);
            $table->string('kode_simpanan',100)->default('KS123456');
            $table->string('type')->default('deposit');
            $table->bigInteger('amount')->default(0);
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft Delete

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

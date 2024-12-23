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
        Schema::create('buku_tabungans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('no_rek')->default(20241123);
            $table->foreignId('nasabah_id')->default(1);
            $table->bigInteger('balance')->default(0);
            $table->enum('status', ['aktif','non-aktif'])->default('aktif');
            $table->string('notes')->nullable();
            $table->timestamp('closed_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_tabungans');
    }
};

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
            $table->unsignedBigInteger('nasabah_id');
            $table->string('no_rek')->unique();
            $table->decimal('balance', 15)->default(0);
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->string('notes')->nullable();
            $table->timestamp('closed_date')->nullable();
            $table->timestamps();

            $table->foreign('nasabah_id')->references('id')->on('nasabahs')->onDelete('cascade');


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

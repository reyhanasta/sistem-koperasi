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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profile_pict')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('master_jabatan_id')->constrained('master_jabatans')->onDelete('cascade');
            $table->string('email')->unique()->nullable();
            $table->bigInteger('gaji')->default(1000000)->nullable(false);
            $table->enum('gender', ['male','female'])->nullable(false)->default('male');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('join_date')->default(now());
            $table->text('desc')->nullable();
            $table->enum('status', ['kontrak','tetap','berhenti'])->nullable(false)->default('kontrak');
            $table->timestamps();
            $table->softDeletes(); // Soft Delete

            // Menambahkan indeks
            $table->index('master_jabatan_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pegawais');
    }
};

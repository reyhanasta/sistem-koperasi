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
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->id(); // ID Nasabah (ID)
            $table->string('name'); // Nama (Name)
            $table->string('ktp')->unique()->nullable(); // Nomor KTP (Kartu Tanda Penduduk)
            $table->enum('gender', ['male', 'female'])->default('male'); // Jenis Kelamin (Gender)
            $table->string('phone'); // Nomor Telepon (Phone)
            $table->string('ktp_image_path')->nullable(); // Kolom untuk menyimpan path/URL gambar KTP
            $table->string('address'); // Alamat (Address)
            $table->date('date_of_birth')->nullable(); // Tanggal Lahir (Date of Birth)
            $table->date('closure_date')->nullable(); // Tanggal Penutupan (Closure Date)
            $table->timestamps(); // Tanggal Pembuatan dan Perubahan Data
            $table->softDeletes(); // Enables soft deleting for the table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabahs');
    }
};

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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profile_pict')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('gaji')->default(1000000);
            $table->enum('gender',['male','female']);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('join_date')->default(now());
            $table->string('desc')->nullable();
            $table->enum('status',['kontrak','tetap'])->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft Delete

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

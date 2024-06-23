<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai_kepala_cabangs', function (Blueprint $table) {
            $table->id('id_kepala_cabang');
            $table->string('nama_kepala_cabang');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_jabatan');
            $table->string('cabang', 128)->nullable();
            $table->unsignedBigInteger('id_direksi');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('cascade');
            $table->foreign('id_direksi')->references('id_direksi')->on('direksis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai_kepala_cabangs');
    }
};

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
        Schema::create('pegawai_supervisors', function (Blueprint $table) {
            $table->id('id_supervisor');
            $table->string('nama_supervisor');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kepala_cabang');
            $table->unsignedBigInteger('id_jabatan');
            $table->string('cabang', 128)->references('cabang')->on('users');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();

            $table->foreign('id_kepala_cabang')->references('id_kepala_cabang')->on('pegawai_kepala_cabangs')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_supervisors');
    }
};

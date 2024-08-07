<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pegawai_kepala_cabangs', function (Blueprint $table) {
            $table->id('id_kepala_cabang');
            $table->string('nama_kepala_cabang');
            // Tambahkan kolom-kolom tambahan sesuai kebutuhan
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_direksi')->nullable();
   
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_direksi')->references('id_direksi')->on('direksis')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
          
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_kepala_cabangs');
    }
};

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
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->unsignedBigInteger('no')->primary();
            $table->string('nama');
            $table->string('pokok');
            $table->string('bunga');
            $table->string('denda');
            $table->integer('total');
            $table->string('account_officer');
            $table->text('keterangan');
            $table->datetime('ttd');
            $table->datetime('kembali');
            $table->string('cabang', 128)->references('cabang')->on('users');
            $table->unsignedBigInteger('id_account_officer');
            $table->unsignedBigInteger('id_kepala_cabang');
            $table->unsignedBigInteger('id_admin_kas');
            $table->timestamps();

            $table->foreign('id_kepala_cabang')->references('id_kepala_cabang')->on('pegawai_kepala_cabangs')->onDelete('cascade');
            $table->foreign('id_account_officer')->references('id_account_officer')->on('pegawai_account_offices')->onDelete('cascade');
            $table->foreign('id_admin_kas')->references('id_admin_kas')->on('pegawai_admin_kas')->onDelete('cascade');
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
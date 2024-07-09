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
            $table->unsignedBigInteger('no')->autoIncrement();
            $table->string('nama');
            $table->decimal('pokok', 15, 2);
            $table->decimal('bunga', 15, 2);
            $table->decimal('denda', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('account_officer');
            $table->text('keterangan');
            $table->string('ttd');
            $table->datetime('kembali');
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_wilayah');
            $table->unsignedBigInteger('id_account_officer')->nullable();
            $table->unsignedBigInteger('id_admin_kas');
            $table->string('bukti')->nullable();
            $table->timestamps();

            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayahs')->onDelete('cascade');
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

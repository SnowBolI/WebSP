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
        Schema::create('pegawai_admin_kas', function (Blueprint $table) {
            $table->id('id_admin_kas');
            $table->string('nama_admin_kas');

            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_supervisor')->nullable();
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_wilayah');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_admin_kas');
    }
};

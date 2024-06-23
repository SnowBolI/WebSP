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
        Schema::create('pegawai_account_offices', function (Blueprint $table) {
            $table->bigIncrements('id_account_officer');
            $table->string('nama_account_officer');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_admin_kas');
            $table->unsignedBigInteger('id_jabatan');
            $table->string('email')->unique();
            $table->string('cabang', 128)->references('cabang')->on('users');
            $table->string('password');
            $table->timestamps();
            $table->foreign('id_admin_kas')->references('id_admin_kas')->on('pegawai_admin_kas')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_account_offices');
    }
};

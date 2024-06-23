<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id_user');
        $table->unsignedBigInteger('jabatan_id')->nullable();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('cabang', 128)->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->string('api_token')->unique()->nullable()->default(null);
        $table->timestamps();
    
        $table->foreign('jabatan_id')->references('id_jabatan')->on('jabatans')->onDelete('set null');
    });

    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('id_user')->nullable()->on('users')->onDelete('cascade');
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('cabang');
    });
    Schema::dropIfExists('users');
    Schema::dropIfExists('sessions');
}
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('nama');
            $table->text('alamat');
            $table->string('telp');
            $table->string('kota');
            $table->enum('jeniskelamin', ['P', 'L']);
            $table->date('tgllahir');
            $table->enum('role', ['member', 'admin']);
            $table->enum('status', ['aktif', 'non aktif'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
        });
         Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
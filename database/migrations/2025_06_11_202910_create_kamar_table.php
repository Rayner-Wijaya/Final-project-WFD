<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->foreignId('jenis_kamar_id')->constrained('jenis_kamar');
            $table->integer('harga');
            $table->enum('status', ['tersedia', 'dipesan'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamar');
    }
};
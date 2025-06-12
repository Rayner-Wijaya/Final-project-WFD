<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('d_booking', function (Blueprint $table) {
            $table->id('nodetail');
            $table->string('nobooking');
            $table->foreignId('nomerkamar')->constrained('kamar', 'id');
            $table->date('tglcheckin');
            $table->date('tglcheckout');
            $table->integer('harga');
            $table->enum('status', ['pending', 'dibayar', 'batal'])->default('pending');
            $table->timestamps();
            
            $table->foreign('nobooking')->references('nobooking')->on('h_booking');
        });
    }

    public function down()
    {
        Schema::dropIfExists('d_booking');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('h_booking', function (Blueprint $table) {
            $table->string('nobooking')->primary();
            $table->dateTime('tglbooking');
            $table->string('username');
            $table->enum('status', ['pending', 'dibayar', 'batal'])->default('pending');
            $table->timestamps();
            $table->string('username')->nullable()->default(null)->change();
            $table->foreign('username')->references('username')->on('users')->default(null);
        });
    }

    public function down()
    {
        Schema::dropIfExists('h_booking');
    }
};
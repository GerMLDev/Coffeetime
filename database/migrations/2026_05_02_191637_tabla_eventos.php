<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->date('fecha');
            $table->time('hora');
            $table->string('enlace');
            $table->unsignedBigInteger('idnivel');
            $table->unsignedBigInteger('idprofesor');
            $table->timestamps();

            $table->foreign('idnivel')->references('id')->on('nivel');
            $table->foreign('idprofesor')->references('id')->on('profesor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
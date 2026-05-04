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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idalumno');
            $table->unsignedBigInteger('idevento');
            $table->timestamp('fecha_inscripcion')->useCurrent();
            $table->timestamps();

            $table->foreign('idalumno')->references('id')->on('alumno')->onDelete('cascade');
            $table->foreign('idevento')->references('id')->on('eventos')->onDelete('cascade');
            $table->unique(['idalumno', 'idevento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};

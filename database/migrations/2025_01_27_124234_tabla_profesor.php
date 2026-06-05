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

        Schema::create('profesor', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_profesor');
            $table->string('apellidos_profesor');
            $table->string('email_profesor');
            $table->string('dni_profesor');
            $table->string('usuario_prof');
            $table->string('contrasena_prof');


            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['PDF', 'Video', 'Enlace']);
            $table->string('enlace');
            $table->unsignedBigInteger('idprofesor');
            $table->timestamps();
            $table->foreign('idprofesor')->references('id')->on('profesor')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};

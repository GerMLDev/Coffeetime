<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('profesor', function (Blueprint $table) {
            $table->unsignedBigInteger('idusuario')->nullable()->after('idrol');
            $table->foreign('idusuario')->references('id')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::table('profesor', function (Blueprint $table) {
            $table->dropForeign(['idusuario']);
            $table->dropColumn('idusuario');
        });
    }
};
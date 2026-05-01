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
            Schema::table('alumno', function (Blueprint $table) {
                $table->unsignedBigInteger('idprofesor'); 
                $table->unsignedBigInteger('idnivel'); 
                $table->unsignedBigInteger('idrol'); 
    
                $table->foreign('idrol')->references('id')->on('rol')->onDelete('cascade');
                $table->foreign('idprofesor')->references('id')->on('profesor')->onDelete('cascade');
                $table->foreign('idnivel')->references('id')->on('nivel')->onDelete('cascade');
            });
        }
    
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('alumno', function (Blueprint $table) {
                $table->dropForeign(['idprofesor']);
                $table->dropForeign(['idnivel']);
                 $table->dropForeign(['idrol']);
                $table->dropColumn('idrol');
                $table->dropColumn('idprofesor');
                $table->dropColumn('idnivel');
            });
        }
    };
    
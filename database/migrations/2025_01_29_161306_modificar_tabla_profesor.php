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
    
            Schema::table('profesor', function (Blueprint $table) {
                $table->string('email_profesor')->unique()->change();
                $table->string('dni_profesor')->unique()->change();
                $table->string('usuario_prof')->unique()->change();
                });
    
        }
    
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
          
            Schema::table('profesor', function (Blueprint $table) {
                $table->string('email_profesor')->change();
                $table->string('dni_profesor')->change();
                $table->string('usuario_prof')->change();
            });

        }
    }; 
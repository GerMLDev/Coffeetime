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
        Schema::table('recursos', function (Blueprint $table) {
            $table->unsignedBigInteger('idnivel')->after('idprofesor');
            $table->foreign('idnivel')->references('id')->on('nivel');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('recursos', function (Blueprint $table) {
            $table->dropForeign(['idnivel']);
            $table->dropColumn('idnivel');
        });
    }
};

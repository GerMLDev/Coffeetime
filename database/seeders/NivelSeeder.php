<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelSeeder extends Seeder
{
    public function run()
    {
        DB::table('nivel')->insert([
            ['id' => 1, 'nivel' => 'Básico 1'],
            ['id' => 2, 'nivel' => 'Básico 2'],
            ['id' => 3, 'nivel' => 'Intermedio 1'],
            ['id' => 4, 'nivel' => 'Intermedio 2']
        ]);
    }
}

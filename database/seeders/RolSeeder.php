<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['id' => 1, 'rol' => 'admin'],
            ['id' => 2, 'rol' => 'profesor'],
                        ['id' =>3, 'rol' => 'alumno'],

        ];

        DB::table('rol')->insert($roles);
    }
}

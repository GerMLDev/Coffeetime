<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuarios = [
            [
                'usuario' => 'administrador',
                'contraseña' => Hash::make('administrador'),
                'email' => 'admin@gmail.com',
                'dni' => '12345678A',
                'idrol' => 1, // Administrador
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'usuario' => 'profesores',
                'contraseña' => Hash::make('profesores'),
                'email' => 'profesor@gmail.com',
                'dni' => '87654321B',
                'idrol' => 2, // Profesor
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            [
                'usuario' => 'alumno',
                'contraseña' => Hash::make('alumnoprueba'),
                'email' => 'alumno@gmail.com',
                'dni' => '12345678P',
                'idrol' => 3, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('usuario')->insert($usuarios);
    }
}

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
        DB::table('usuario')->insert([
            [
                'id' => 1,
                'usuario' => 'administrador',
                'contraseña' => Hash::make('administrador'),
                'email' => 'admin@gmail.com',
                'dni' => '00000000A',
                'idrol' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'usuario' => 'pedrog',
                'contraseña' => Hash::make('password1'),
                'email' => 'pedro.garcia@gmail.com',
                'dni' => '12345678A',
                'idrol' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'usuario' => 'sergiom',
                'contraseña' => Hash::make('password2'),
                'email' => 'sergio.martinez@gmail.com',
                'dni' => '23456789B',
                'idrol' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'usuario' => 'luciar',
                'contraseña' => Hash::make('password3'),
                'email' => 'lucia.rodriguez@gmail.com',
                'dni' => '34567890C',
                'idrol' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'usuario' => 'elenas',
                'contraseña' => Hash::make('password4'),
                'email' => 'elena.sanchez@gmail.com',
                'dni' => '45678901D',
                'idrol' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'usuario' => 'alumno',
                'contraseña' => Hash::make('alumnoprueba'),
                'email' => 'alumno@gmail.com',
                'dni' => '12345678P',
                'idrol' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
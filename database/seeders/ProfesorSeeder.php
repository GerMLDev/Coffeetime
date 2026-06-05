<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfesorSeeder extends Seeder
{
    public function run()
    {
        DB::table('profesor')->insert([
            [
                'id' => 1,
                'nombre_profesor' => 'Pedro',
                'apellidos_profesor' => 'Garcia Lopez',
                'email_profesor' => 'pedro.garcia@gmail.com',
                'dni_profesor' => '12345678A',
                'usuario_prof' => 'pedrog',
                'contrasena_prof' => Hash::make('password1'),
                'idnivel' => 1,
                'idrol' => 2,
                'idusuario' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'nombre_profesor' => 'Sergio',
                'apellidos_profesor' => 'Martinez Fernandez',
                'email_profesor' => 'sergio.martinez@gmail.com',
                'dni_profesor' => '23456789B',
                'usuario_prof' => 'sergiom',
                'contrasena_prof' => Hash::make('password2'),
                'idnivel' => 2,
                'idrol' => 2,
                'idusuario' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'nombre_profesor' => 'Lucia',
                'apellidos_profesor' => 'Rodriguez Gomez',
                'email_profesor' => 'lucia.rodriguez@gmail.com',
                'dni_profesor' => '34567890C',
                'usuario_prof' => 'luciar',
                'contrasena_prof' => Hash::make('password3'),
                'idnivel' => 3,
                'idrol' => 2,
                'idusuario' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'nombre_profesor' => 'Elena',
                'apellidos_profesor' => 'Sanchez Perez',
                'email_profesor' => 'elena.sanchez@gmail.com',
                'dni_profesor' => '45678901D',
                'usuario_prof' => 'elenas',
                'contrasena_prof' => Hash::make('password4'),
                'idnivel' => 4,
                'idrol' => 2,
                'idusuario' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

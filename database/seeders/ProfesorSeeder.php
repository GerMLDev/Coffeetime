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
                'contraseña_prof' => Hash::make('password1'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                                'idrol' => '2',

            ],
            [
                'id' => 2,
                'nombre_profesor' => 'Sergio',
                'apellidos_profesor' => 'Martinez Fernandez',
                'email_profesor' => 'sergio.martinez@gmail.com',
                'dni_profesor' => '23456789B',
                'usuario_prof' => 'sergiom',
                'contraseña_prof' => Hash::make('password2'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                                                'idrol' => '2',

            ],
            [
                'id' => 3,
                'nombre_profesor' => 'Lucia',
                'apellidos_profesor' => 'Rodriguez Gomez',
                'email_profesor' => 'lucia.rodriguez@gmail.com',
                'dni_profesor' => '34567890C',
                'usuario_prof' => 'luciar',
                'contraseña_prof' => Hash::make('password3'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                                                'idrol' => '2',

            ],
            [
                'id' => 4,
                'nombre_profesor' => 'Elena',
                'apellidos_profesor' => 'Sanchez Perez',
                'email_profesor' => 'elena.sanchez@gmail.com',
                'dni_profesor' => '45678901D',
                'usuario_prof' => 'elenas',
                'contraseña_prof' => Hash::make('password4'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                                                'idrol' => '2',

            ]
        ]);
    }
}

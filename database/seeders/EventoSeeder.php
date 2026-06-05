<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('eventos')->insert([
            [
                'titulo' => 'Taller de introducción al café',
                'fecha' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'hora' => '10:00:00',
                'enlace' => 'https://meet.example.com/taller-intro-cafe',
                'idnivel' => 1,
                'idprofesor' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Sesión práctica de cata de café',
                'fecha' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'hora' => '18:00:00',
                'enlace' => 'https://meet.example.com/cata-cafe',
                'idnivel' => 1,
                'idprofesor' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Preparación de espresso perfecta',
                'fecha' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'hora' => '11:00:00',
                'enlace' => 'https://meet.example.com/espresso-perfecto',
                'idnivel' => 2,
                'idprofesor' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Técnicas de molienda y dosificación',
                'fecha' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'hora' => '17:00:00',
                'enlace' => 'https://meet.example.com/molienda-dosificacion',
                'idnivel' => 2,
                'idprofesor' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Latte art para baristas intermedios',
                'fecha' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'hora' => '16:00:00',
                'enlace' => 'https://meet.example.com/latte-art-intermedio',
                'idnivel' => 3,
                'idprofesor' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Técnicas avanzadas de extracción',
                'fecha' => Carbon::now()->addDays(8)->format('Y-m-d'),
                'hora' => '19:00:00',
                'enlace' => 'https://meet.example.com/extraccion-avanzada',
                'idnivel' => 3,
                'idprofesor' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Calibración de máquinas de café',
                'fecha' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'hora' => '14:00:00',
                'enlace' => 'https://meet.example.com/calibracion-maquinas',
                'idnivel' => 4,
                'idprofesor' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Servicio de café premium y atención al cliente',
                'fecha' => Carbon::now()->addDays(6)->format('Y-m-d'),
                'hora' => '12:00:00',
                'enlace' => 'https://meet.example.com/servicio-premium',
                'idnivel' => 4,
                'idprofesor' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

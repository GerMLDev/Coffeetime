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
                'titulo' => 'Clase A1 - Números',
                'fecha' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'hora' => '10:00:00',
                'enlace' => 'https://meet.example.com/',
                'idnivel' => 1,
                'idprofesor' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase A1 - Letras',
                'fecha' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'hora' => '18:00:00',
                'enlace' => 'https://meet.example.com/',
                'idnivel' => 1,
                'idprofesor' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase A2 - Verbos irregulares',
                'fecha' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'hora' => '11:00:00',
                'enlace' => 'https://meet.example.com/',
                'idnivel' => 2,
                'idprofesor' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase A2 - Verbos modales',
                'fecha' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'hora' => '17:00:00',
                'enlace' => 'https://meet.example.com/',
                'idnivel' => 2,
                'idprofesor' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase B1 - Verbos irregulares 2',
                'fecha' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'hora' => '16:00:00',
                'enlace' => 'https://meet.example.com/',
                'idnivel' => 3,
                'idprofesor' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase B1 - Presente Perfecto',
                'fecha' => Carbon::now()->addDays(8)->format('Y-m-d'),
                'hora' => '19:00:00',
                'enlace' => 'https://meet.example.com/',
                'idnivel' => 3,
                'idprofesor' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase B2 - Entrevista de trabajo',
                'fecha' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'hora' => '14:00:00',
                'enlace' => 'https://meet.example.com',
                'idnivel' => 4,
                'idprofesor' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase B2 - Vocabulario especializado',
                'fecha' => Carbon::now()->addDays(6)->format('Y-m-d'),
                'hora' => '12:00:00',
                'enlace' => 'https://meet.example.com/',
                'idnivel' => 4,
                'idprofesor' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

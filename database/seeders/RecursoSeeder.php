<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecursoSeeder extends Seeder
{
    public function run()
    {
        DB::table('recursos')->insert([
            [
                'titulo' => 'Gramática avanzada',
                'tipo' => 'Enlace',
                'enlace' => 'https://www.liveworksheets.com/es/worksheet/en/esl-grammar/59098',
                'idprofesor' => 1,
                'idnivel' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Ejercicios de comprensión',
                'tipo' => 'Video',
                'enlace' => 'https://www.youtube.com/watch?v=SceDmiBEESI',
                'idprofesor' => 1,
                'idnivel' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Video de pronunciación',
                'tipo' => 'Enlace',
                'enlace' => 'https://www.liveworksheets.com/es/worksheet/en/esl-grammar/59098',
                'idprofesor' => 2,
                'idnivel' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Lista de vocabulario',
                'tipo' => 'PDF',
                'enlace' => 'https://www.liveworksheets.com/es/node/59098/download-pdf',
                'idprofesor' => 2,
                'idnivel' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Clase en vivo grabada',
                'tipo' => 'Video',
                'enlace' => 'https://www.youtube.com/watch?v=SceDmiBEESI',
                'idprofesor' => 3,
                'idnivel' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Guía de lectura',
                'tipo' => 'Enlace',
                'enlace' => 'http://liveworksheets.com/es/worksheet/en/esl-grammar/274313',
                'idprofesor' => 3,
                'idnivel' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Ejercicios de gramática básica',
                'tipo' => 'PDF',
                'enlace' => 'https://www.liveworksheets.com/es/node/59098/download-pdf',
                'idprofesor' => 4,
                'idnivel' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'titulo' => 'Podcast de conversación',
                'tipo' => 'Enlace',
                'enlace' => 'https://www.liveworksheets.com/es/worksheet/en/esl-grammar/541385',
                'idprofesor' => 4,
                'idnivel' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profesor extends Model
{
    protected $table = "profesor";

    public function obtenerProfesor($id)
    {
        return self::select('profesor.*')
        ->where('profesor.id', $id)
        ->first();

    }

 

}

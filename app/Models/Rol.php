<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rol extends Model
{
    protected $table = "rol";

    public function obtenerRol()
    {
        return self::select('rol.*')
        ->get();

    }

    public function usuarios(){

        return $this->hasMany(Usuario::class, 'id', 'idrol');

    }
     
    

}


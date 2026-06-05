<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = "rol";
    //Recuperar rol

    public function obtenerRol()
    {
        return self::select('rol.*')
        ->get();

    }
    //Rol para usuarios

    public function usuarios(){

        return $this->hasMany(Usuario::class, 'id', 'idrol');

    }



}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo de rol para unir usuarios con permisos
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


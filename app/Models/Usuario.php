<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable {
    use HasFactory, Notifiable;

    protected $table = "usuario";


    public function getAuthPassword()
    {
        return $this->contraseña;
    }


    public function obtenerUsuarioRol($id)
    {
        return self::select(
            'usuario.*',
            DB::raw("CONCAT(rol.rol) AS ROL")
        )
        ->join('rol', 'usuario.idrol', '=', 'rol.id')
        ->where('usuario.id', $id)
        ->first();

    }
    public function obtenerUsuario(){

         return self::select(
        'usuario.*',
        DB::raw("rol.rol AS ROL")
    )
    ->join('rol', 'usuario.idrol', '=', 'rol.id')
    ->get();
    }
//Recupera el rol para usuario

public function role() {
    return $this->belongsTo(Rol::class, 'idrol');
}

//Comprueba si el usuario tiene un rol ('admin', 'alumno', 'profesor').

public function hasRole($rol) {
    return $this->role && $this->role->rol === $rol;
}

}

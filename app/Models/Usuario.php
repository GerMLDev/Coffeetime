<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Modelo de usuario con auth y rol
class Usuario extends Authenticatable {
    use HasFactory, Notifiable;

    protected $table = "usuario";
    protected $hidden = [
    'contraseña',
    'remember_token',
];

    // Devuelve la contraseña para auth
    public function getAuthPassword()
    {
        return $this->contraseña;
    }


    // Devuelve el usuario junto con su rol por ID
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
    // Saca TODOS los usuarios con su rol
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

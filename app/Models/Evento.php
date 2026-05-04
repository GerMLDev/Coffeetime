<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = "eventos";

    protected $fillable = [
        'titulo', 'fecha', 'hora', 'enlace', 'idnivel', 'idprofesor'
    ];

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'idnivel');
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'idprofesor');
    }
}
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $table = "recursos";
    protected $fillable = ['titulo', 'tipo', 'enlace', 'idprofesor'];


    //Recuperar niveles y profesores 
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'idprofesor');
    }
    public function nivel()
{
    return $this->belongsTo(Nivel::class, 'idnivel');
}
}

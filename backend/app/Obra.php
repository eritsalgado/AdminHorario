<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    protected $table = 'obras';

    //Relaciones
    public function supervisor(){
        //Vamos a devolver todos los datos del usuario que ha creado el registro
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
    public function equipo(){
        //Vamos a devolver todos los registros del equipo asignado a esta obra
        return $this->hasMany('App\Equipo', 'obra_id');
    }
}

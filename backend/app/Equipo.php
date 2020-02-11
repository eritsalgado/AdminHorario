<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';

    //Relación
    public function usuario(){
        //Vamos a devolver todos los datos del usuario que ha creado el registro
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
    public function obra(){
        //Vamos a devolver todos los datos del usuario que ha creado el registro
        return $this->belongsTo('App\Obra', 'obra_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    //Relación
    public function usuario(){
        //Vamos a devolver todos los datos del usuario que ha creado el registro
        return $this->belongsTo('App\Usuario', 'usuario_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';
    
    //relacion
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}

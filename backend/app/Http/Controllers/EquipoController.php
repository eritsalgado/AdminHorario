<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Equipo;

class EquipoController extends Controller
{
    public function index(){
        $equipo = Equipo::all()
                        ->load('usuario')
                        ->load('obra');
        return response()->json(array(
            'integrantes' => $equipo,
            'status' => 'success'
        ),200);
    }
    public function store(Request $request){
        //Recibir datos POST
        $json = $request->input('json', null);
        $params =json_decode($json);
        
        //Se verifica datos y asignarlos
        $obra_id     = (!is_null($json) && isset($params->obra_id))       ? $params->obra_id       : null;
        $usuario_id  = (!is_null($json) && isset($params->usuario_id))    ? $params->usuario_id    : null;

        if( !is_null($obra_id) && !is_null($usuario_id) ){
            //Crear registro de equipo de obra
            $equipo = new Equipo();
            $equipo->obra_id    = $obra_id;
            $equipo->usuario_id  = $usuario_id;

            //Comprobar que no se repita su registro en el equipo
            $existencia_en_equipo = Equipo::where('usuario_id', '=', $usuario_id)
                                        ->where('obra_id', '=', $obra_id)
                                        ->first();
            if(count((array)$existencia_en_equipo) == 0){
                //Guardar el registro
                $equipo->save();
                
                $data = array(
                    'data' => $equipo,
                    'status' => 'success',
                    'code' => 201,
                    'message' => 'Empleado suscrito correctamente.'
                );
            }else{
                //No guardar usuario por que ya existe
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro duplicado, este empleado ya está en el equipo.'
                );
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Registro no creado, faltan datos importantes.'
            );
        }

        return response()->json($data, 200);
    }
}

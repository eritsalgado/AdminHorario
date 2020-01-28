<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Obra;
use App\Helpers\JwtAuth;

class ObraController extends Controller
{
    public function index(){
        $obra = Obra::all()
                    ->load('supervisor')
                    ->load('equipo');
        return response()->json(array(
            'obras' => $obra,
            'status' => 'success'
        ),200);
    }
    public function store(Request $request){


        //Para JWT (seguridad con inicio de sesion)
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if($checkToken){
            //Recibir datos POST
            $json = $request->input('json', null);
            $params =json_decode($json);
            
            //Se verifica datos y asignarlos
            $usuario_id     = (!is_null($json) && isset($params->usuario_id))    ? $params->usuario_id    : null;
            $ubicacion      = (!is_null($json) && isset($params->ubicacion))     ? $params->ubicacion     : null;
            $nombre_obra    = (!is_null($json) && isset($params->nombre_obra))   ? $params->nombre_obra   : null;
            $fecha_inicio   = (!is_null($json) && isset($params->fecha_inicio))  ? $params->fecha_inicio  : null;
            $fecha_termino  = (!is_null($json) && isset($params->fecha_termino)) ? $params->fecha_termino : null;

            if( !is_null($usuario_id) && !is_null($ubicacion) && !is_null($nombre_obra) && !is_null($fecha_inicio) ){
                //Crear registro de una nueva obra
                $obra = new Obra();
                $obra->usuario_id    = $usuario_id;
                $obra->ubicacion     = $ubicacion;
                $obra->nombre_obra   = $nombre_obra;
                $obra->fecha_inicio  = $fecha_inicio;
                $obra->fecha_termino = $fecha_termino;

                //Comprobar que no se repita la obra con su encargado
                $existencia_obra = Obra::where('usuario_id', '=', $usuario_id    )
                                    ->where('ubicacion',    '=', $ubicacion   )
                                    ->where('nombre_obra', '=', $nombre_obra  )
                                    ->where('fecha_inicio', '=', $fecha_inicio)
                                    ->first();
                if(count((array)$existencia_obra) == 0){
                    //Guardar el registro
                    $obra->save();
                                    
                    $data = array(
                        'data' => $obra,
                        'status' => 'success',
                        'code' => 201,
                        'message' => 'Obra registrada correctamente.'
                    );
                }else{
                    //No guardar usuario por que ya existe
                    $data = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Registro duplicado, esta obra ya está asignada al usuario.'
                    );
                }
            }else{
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro no creado, faltan datos importantes.'
                );
            }

            
        }else{
            $data = array(
                'status' => 'error',
                'code' => 300,
                'message' => 'No tiene los permisos necesarios para crear este registro.'
            );
        }
        
        return response()->json($data, 200);

        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Horario;
use App\Usuario;

class HorarioController extends Controller
{
    public function index(){
        $horario = Horario::all()
                        ->load('usuario');
        return response()->json(array(
            'registro' => $horario,
            'status' => 'success'
        ),200);
    }
    public function hoy(Request $request){
        //Recibir datos POST
        $json = $request->input('json', null);
        $params =json_decode($json);
        
        $fecha  = (!is_null($json) && isset($params->fecha))     ? $params->fecha    : null;
        
        if(is_null($fecha)){
            $fecha = date("Y-m-d");
        }
        $reporte = Horario::where('fecha', '=', $fecha)->get();

        $data = array(
        'reporte' => $reporte,
        'message' => 'ya quedo'
        );

        return response()->json($data, 200);
    }
    public function store(Request $request){
        
        //Recibir datos POST
        $json = $request->input('json', null);
        $params =json_decode($json);
        
        //Se verifica datos y asignarlos
        $usuario_id     = (!is_null($json) && isset($params->usuario_id))       ? $params->usuario_id       : null;
        $hora_ingreso   = (!is_null($json) && isset($params->hora_ingreso))     ? $params->hora_ingreso     : null;
        $fecha          = (!is_null($json) && isset($params->fecha))            ? $params->fecha            : null;
        $notas          = (!is_null($json) && isset($params->notas))            ? $params->notas            : null;

        //Verificar integridad de datos
        if( !is_null($usuario_id) && !is_null($hora_ingreso) && !is_null($fecha) ){

            //Obtener IP actual
            function getRealIP(){
                if (isset($_SERVER["HTTP_CLIENT_IP"]))
                {
                    return $_SERVER["HTTP_CLIENT_IP"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
                {
                    return $_SERVER["HTTP_X_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
                {
                    return $_SERVER["HTTP_X_FORWARDED"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
                {
                    return $_SERVER["HTTP_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED"]))
                {
                    return $_SERVER["HTTP_FORWARDED"];
                }
                else
                {
                    return $_SERVER["REMOTE_ADDR"];
                }

            }
            $ip_usuario = getRealIP();
            //Consultar geolocalización
            $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip_usuario"));
            $city = $geo["geoplugin_city"];
            $region = $geo["geoplugin_regionName"];
            $country = $geo["geoplugin_countryName"];
            $latitude = $geo["geoplugin_latitude"];
            $longitude = $geo["geoplugin_longitude"];


            $ubicacion = $country.", ".$city;

            //Crear registro de horario del dia
            $horario = new Horario();
            $horario->usuario_id    = $usuario_id;
            $horario->hora_ingreso  = $hora_ingreso;
            $horario->fecha = $fecha;
            $horario->notas = $notas;
            $horario->ubicacion = $ubicacion;

            //Comprobar que no se repita su registro
            $existencia_horario = Horario::where('usuario_id', '=', $usuario_id)
                                        ->where('fecha', '=', $fecha)
                                        ->first();
            if(count((array)$existencia_horario) == 0){
                //Guardar el registro
                $horario->save();
                
                $data = array(
                    'data' => $horario,
                    'status' => 'success',
                    'code' => 201,
                    'message' => 'Ingreso registrado correctamente'
                );
            }else{
                //No guardar usuario por que ya existe
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Registro duplicado, este usuario ya registró su ingreso anteriormente el día de hoy.'
                );
            }


        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Horario no creado, faltan datos importantes'
            );
        }

        return response()->json($data, 200);
    }
    public function update($id, Request $request){
        //Recibir datos POST
        $json = $request->input('json', null);
        $params =json_decode($json);
        $params_array = json_decode($json, true);

        $cambio = Horario::where('id', '=', $id )->update($params_array);

        $data = array(
            'hora' => $params,
            'code' => 400,
            'message' => 'quedo'
        );
        return response()->json($data, 200);
    }
    public function semana(Request $request){
       
        //Recibir datos POST
        $json = $request->input('json', null);
        $params =json_decode($json);
        
        //Se verifica datos y asignarlos
        $usuario_id     = (!is_null($json) && isset($params->usuario_id))       ? $params->usuario_id       : null;
        $fecha_inicio   = (!is_null($json) && isset($params->fecha_inicio))     ? $params->fecha_inicio     : null;
        $fecha_fin      = (!is_null($json) && isset($params->fecha_fin))    ? $params->fecha_fin            : null;
       

        //Verificar integridad de datos
        if( !is_null($usuario_id) && !is_null($fecha_inicio) && !is_null($fecha_fin) ){
            $reporte = Horario::where('usuario_id', '=', $usuario_id    )
                                ->where('fecha', '>=', $fecha_inicio   )
                                ->where('fecha', '<=', $fecha_fin  )
                                ->get();
            $usuario = Usuario::where('id', '=', $usuario_id)->first();
            $data = array(
                'usuario'  => $usuario,
                'reporte' => $reporte,
                'message' => 'ya quedo'
            );
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Manda las fechas para el reporte'
            );
        }
                        
        return response()->json($data, 200);
        
    }
    public function general(Request $request){
        //Recibir datos POST
        $json = $request->input('json', null);
        $params =json_decode($json);
        
        //Se verifica datos y asignarlos
        $fecha_inicio   = (!is_null($json) && isset($params->fecha_inicio))     ? $params->fecha_inicio     : null;
        $fecha_fin      = (!is_null($json) && isset($params->fecha_fin))    ? $params->fecha_fin            : null;
       

        //Verificar integridad de datos
        if(!is_null($fecha_inicio) && !is_null($fecha_fin) ){
            $reporte = Horario::where('fecha', '>=', $fecha_inicio   )
                                ->where('fecha', '<=', $fecha_fin  )
                                ->get();

            $data = array(
                'reporte' => $reporte,
                'message' => 'ya quedo'
            );
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Manda las fechas para el reporte'
            );
        }
                        
        return response()->json($data, 200);
    }
}

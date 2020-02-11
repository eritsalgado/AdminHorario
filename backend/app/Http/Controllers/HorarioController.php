<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Horario;

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
    public function store(Request $request){
        //Recibir datos POST
        $json = $request->input('json', null);
        $params =json_decode($json);
        
        //Se verifica datos y asignarlos
        $usuario_id     = (!is_null($json) && isset($params->usuario_id))       ? $params->usuario_id       : null;
        $hora_ingreso   = (!is_null($json) && isset($params->hora_ingreso))     ? $params->hora_ingreso     : null;
        $hora_descanso  = (!is_null($json) && isset($params->hora_descanso))    ? $params->hora_descanso    : null;
        $hora_regreso   = (!is_null($json) && isset($params->hora_regreso))     ? $params->hora_regreso     : null;
        $hora_salida    = (!is_null($json) && isset($params->hora_salida))      ? $params->hora_salida      : null;
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
            $horario->hora_descanso = $hora_descanso;
            $horario->hora_regreso = $hora_regreso;
            $horario->hora_salida = $hora_salida;
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\JwtAuth;

use App\user;

use App\Horario;

class HorarioController extends Controller
{
    public function index(Request $request){
       
        /*
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if($checkToken){
            echo "index de CarController AUTENTICADO"; die();
        }else{
            echo "NO AUTENTICADO -> Index de CarController"; die();
        }
        */

        $horario = Horario::all()->load('user');
        return response()->json(array(
            'horario' => $horario,
            'status' => 'success'
        ), 200);
    }
    public function show($id){
        $horario = Horario::find($id)->load('user');
        return response()->json(array('horario' => $horario, 'status' => 'success'), 200);
    }
    public function store(Request $request){
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if($checkToken){
            //recoger datos con post
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);

            //conseguir el usuario identificado
            $user = $jwtAuth->checkToken($hash, true);

            if($user->role == "Administrador"){
                //validacion
                $validate = \Validator::make($params_array,[
                    'user_id' => 'required',
                    'hora_ingreso' => 'required'
                ]);
            
                if($validate->fails()){
                    return response()->json($validate->errors(), 400);
                }
            

                //guardar el coche
            
                $horario = new Horario();
                $horario->user_id = $params->user_id;
                $horario->hora_ingreso = $params->hora_ingreso;
                
                

                $horario->save();
                
                $data = array(
                    'horario' => $horario,
                    'status' => 'success',
                    'code' => 200,
                );
            }else{
                //devolver error
                $data = array(
                'message' => 'No tienes los permisos para esta operacion',
                'status' => 'error',
                'code' => 300,
            );
            }
        }else{
            //devolver error
            $data = array(
                'message' => 'Login incorrecto',
                'status' => 'error',
                'code' => 300,
            );
        } 

        return response()->json($data, 200);
    }
    public function update($id, Request $request){
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        

        if($checkToken){
            //recoger parametros post
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);
            /*La función array_except nos devuelve los valores del arreglo exceptuando 
            el valor con la llave que le pasemos como parámetro */
            //$new_params = array_except($params_array, ['role']);
            //seguarda el rol enviado desde la pagina
            //$role = (!is_null($json) && isset($params->role)) ? $params->role : null;

             //conseguir el usuario identificado
             $user = $jwtAuth->checkToken($hash, true);

            if($user->role == "Administrador"){
                //se crea la fecha actual
                $fecha_actual = date('Y-m-d', time());
                //actualizar el registro
                $horario = Horario::where('user_id', $id));
                //->update($params_array);

                
                
                foreach($horario as $key => $hora){
                    
                    //se divide la fecha actual
                    list($year_actual, $mes_actual, $dias)=explode($fecha_actual);
                    //se divide la fecha de la bd
                    list($year_bd, $mes_bd, $dia)=explode($hora['created_at']);
                    
                    if($year_actual == $year_bd && $mes_actual == $mes_bd && $dias == $dia){
                    
                        if()
                            //validar los datos
                            $validate = \Validator::make($params_array,[
                                'user_id' => 'required',
                                'hora_inicio_comida' => 'required'
                            ]);
                            
                        
                            if($validate->fails()){
                                return response()->json($validate->errors(), 400);
                            }
                    }
                }


                $data = array(
                    'horario' => $params,
                    'status' => 'success',
                    'code' => 200
                );

            }else{
                 //devolver error
                $data = array(
                'message' => 'no cuentas con los permisos para esto',
                'status' => 'error',
                'code' => 300,
                );
            }

        }else{
            //devolver error
            $data = array(
                'message' => 'no se pudo actualizar',
                'status' => 'error',
                'code' => 300,
            );
        } 

        return response()->json($data, 200);
    }
    public function destroy($id, Request $request){
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if($checkToken){
            //Comprobar que existe el registro
            $horario = Horario::find($id);

            //Borrarlo
            $horario->delete();

            //devolverlo
            $data = array(
                'car' => $horario,
                'status' => 'success',
                'code' => 200
            );
        }else{
            //devolver error
            $data = array(
                'message' => 'login incorrecto',
                'status' => 'error',
                'code' => 400,
            );
        } 

        return response()->json($data, 200);
    }


    
}

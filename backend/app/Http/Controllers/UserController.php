<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\JwtAuth;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;

use App\user;

class UserController extends Controller
{
    public function register(Request $request){
        //recoger post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        //se revisa si llegaron las variables si es asi se guardan si no quedan como null
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $check_in = (!is_null($json) && isset($params->check_in)) ? $params->check_in : null;
        $no_empleado = (!is_null($json) && isset($params->no_empleado)) ? $params->no_empleado : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $surname = (!is_null($json) && isset($params->surname)) ? $params->surname : null;
        $role = (!is_null($json) && isset($params->role)) ? $params->role : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        
        
        //si las variables no vienen nulas estonces seguimos con el registro
        if(!is_null($check_in) && !is_null($no_empleado) && !is_null($name) && !is_null($role)){
             // crear usuario
             $user = new User();
             
             $user->check_in = $check_in;
             $user->no_empleado = $no_empleado;
             $user->name = $name;
             $user->surname = $surname;
             $user->role = $role;
             
            if($role != "Trabajador"){
                if(!is_null($email) && !is_null($password)){

                    $pwd = hash('sha256', $password);
                    $user->password = $pwd;
                    $user->email = $email;
                }else{
                    //validacion
                    $validate = \Validator::make($params_array,[
                        'password' => 'required',
                        'email' => 'required'
                    ]);
                
                    if($validate->fails()){
                        return response()->json($validate->errors(), 400);
                    }
                }
            }
             //comprobar usuario duplicado
             $isset_user = User::where('check_in', '=', $check_in)->first();

             if(count($isset_user) == 0){
                //guardar el usuario
                $user->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario registrado correctamente'
                
                );
             }else{
                 //no guardar por que ya existe
                 $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario duplicado, no puede registrarse'
                );
             }

        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Usuario no creado'
            );
        }
        return response()->json($data, 200);
    }
    public function login(Request $request){
        $jwtAuth = new JwtAuth();

        //recibir post
        $json = $request->input('json', null);
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $getToken = (!is_null($json) && isset($params->gettoken)) ? $params->gettoken : null;
        
        //cifrar la password
        $pwd = hash('sha256', $password);

        if(!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false')){
            $signup = $jwtAuth->signup($email, $pwd);

            
        }elseif($getToken != null){
            $signup = $jwtAuth->signup($email, $pwd, $getToken);

            
        }else{
            $signup = array(
                'status' => 'error',
                'message' => 'envia tus datos por post'
            );
        }

        return response()->json($signup, 200);
    }
}

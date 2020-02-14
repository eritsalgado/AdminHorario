<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Usuario;

class UsuarioController extends Controller
{
    public function index(){
        $usuarios = Usuario::all();
        return response()->json(array(
            'empleados' => $usuarios,
            'status' => 'success'
        ),200);
    }
    public function register(Request $request){
        //Recoger variablas POST
        //Se indica que llegará una variable llamada 'json' y se convertirá a array con json_decode
        $json = $request->input('json', null);
        $params =json_decode($json);

        //Se verifica los datos que debería traer la variable
        $no_empleado    = (!is_null($json) && isset($params->no_empleado))  ? $params->no_empleado  : null;
        $no_nomina      = (!is_null($json) && isset($params->no_nomina))  ? $params->no_nomina  : null;
        $rol            = (!is_null($json) && isset($params->rol))          ? $params->rol          : null;
        $nombre         = (!is_null($json) && isset($params->nombre))       ? $params->nombre       : null;
        $apellido       = (!is_null($json) && isset($params->apellido))     ? $params->apellido     : null;
        $salario        = (!is_null($json) && isset($params->salario))      ? $params->salario      : null;
        $ingreso        = (!is_null($json) && isset($params->ingreso))      ? $params->ingreso      : null;
        $password       = (!is_null($json) && isset($params->password))     ? $params->password     : null;

        //Verificamos que no estén vacios ciertos campos
        if(!is_null($no_empleado) && !is_null($rol) && !is_null($nombre) && !is_null($apellido) && !is_null($salario)){
            //Si se envió una contraseña, hashearla con sal
            if(!is_null($password)){
                $password = password_hash($password, PASSWORD_DEFAULT, ['cost'=>10]);
            }

            //Crear usuario
            $usuario = new Usuario();
            $usuario->no_empleado = $no_empleado;
            $usuario->rol = $rol;
            $usuario->nombre = $nombre;
            $usuario->apellido = $apellido;
            $usuario->salario = $salario;
            $usuario->ingreso = $ingreso;
            $usuario->password = $password;

            //Comprobar que no se está repitiendo el empleado
            $existencia_usuario = Usuario::where('no_empleado', '=', $no_empleado)->first();
            if(count((array)$existencia_usuario) == 0){
                //Guardar el usuario
                $usuario->save();
                
                $data = array(
                    'status' => 'success',
                    'code' => 201,
                    'message' => 'Usuario registrado correctamente'
                );
            }else{
                //No guardar usuario por que ya existe
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario duplicado, no se puede registrar'
                );
            }

        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Usuario no creado, faltan datos importantes'
            );
        }

        //Al final siempre se debe devolver una respuesta
        return response()->json($data, 200);

    }
    public function login(Request $request){
        $jwtAuth = new JwtAuth();
        //Recibir datos por POST
        $json = $request->input('json', null);
        $params = json_decode($json);

        $no_empleado= (!is_null($json) && isset($params->no_empleado))   ? $params->no_empleado : null;
        $password   = (!is_null($json) && isset($params->password))      ? $params->password    : null;
        $getToken   = (!is_null($json) && isset($params->getToken))      ? $params->getToken    : null;

        //Comprobar password
        if(!is_null($no_empleado) && !is_null($password) && ($getToken == null || $getToken == 'false') ){
            $signup = $jwtAuth->signup($no_empleado, $password);
        }elseif($getToken != null){
            $signup = $jwtAuth->signup($no_empleado, $password, $getToken);
        }else{
            $signup = array(
                'status' => 'error',
                'message' => 'Envia tus datos por metodo POST'
            );
        }

        
        return response()->json($signup, 200);
    }
}

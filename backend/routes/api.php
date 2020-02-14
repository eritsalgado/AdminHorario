<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// paginaweb.com/api/register -> get
// paginaweb.com/api/horario -> any [get, post, put, delete]
Route::get('/usuarios','UsuarioController@index');
Route::post('/register','UsuarioController@register');
Route::post('/login','UsuarioController@login');
Route::post('/semana','HorarioController@semana');
Route::post('/general','HorarioController@general');
Route::post('/hoy','HorarioController@hoy');      
Route::resource('horario','HorarioController');
Route::resource('equipo','EquipoController');
Route::resource('obra','ObraController');

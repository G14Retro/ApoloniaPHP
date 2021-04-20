<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'apolonia'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');
    Route::get('listarPacientes','AdministratorController@listarPacientes'); 
    Route::post('crearUsuario','AdministratorController@crearUsuario');
    Route::post('editarUsuario','AdministratorController@editarUsuario');   
    
    
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('dispoHorario','PatientController@dispoHorario');
        Route::post('actualizarInformacion', 'PatientController@actualizarInformacion');
        Route::post('agendaCita', 'PatientController@agendarCita');
        Route::post('historial', 'PatientController@historial');
        Route::post('pacienteMedico', 'DoctorController@pacienteMedico');
        Route::post('verAntecedentes', 'DoctorController@verAntecedentes');
        Route::post('guardarAntecedente', 'DoctorController@guardarAntecedente');
        Route::get('verDispo', 'ReceptionistController@verDispo');
        Route::get('verMedicos', 'ReceptionistController@verMedicos');
        Route::get('verConsultorios', 'ReceptionistController@verConsultorios');
        Route::get('verConsultas', 'ReceptionistController@verConsultas');
        Route::get('verDisponibilidades', 'ReceptionistController@verDisponibilidades');
        Route::post('createDispo','ReceptionistController@createDispo');
        Route::post('dispo','ReceptionistController@dispo');
        Route::put('editDispo/{id}','ReceptionistController@editDispo');
        Route::get('verDocumento', 'AdministratorController@verDocumento');
        Route::get('verEstado' , 'AdministratorController@verEstado');
        Route::get('verTusuario' , 'AdministratorController@verTusuario');
        Route::post('buscarUsuario','AdministratorController@buscarUsuario');
        Route::put('actualizarUsuario/{id}','AdministratorController@actualizarUsuario');

    });
});
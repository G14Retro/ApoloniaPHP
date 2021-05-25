<?php

use App\Http\Controllers\ReceptionistController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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
        Route::get('verPacientes', 'DoctorController@verPacientes');
        Route::get('pacienID/{id}', 'DoctorController@pacienID');
        Route::get('verOdonto/{id}', 'DoctorController@verOdonto');
        Route::post('guardarOdonto', 'DoctorController@guardarOdonto');
        Route::get('cargarOdonto/{id}', 'DoctorController@cargarOdonto');
        Route::get('verAntecedenteID/{id}', 'DoctorController@verAntecedenteID');
        Route::post('guardarAntecedenteId', 'DoctorController@guardarAntecedenteId');
        Route::get('getDientes', 'DoctorController@getDientes');
        Route::get('getSintomas', 'DoctorController@getSintomas');
        Route::get('getTratamientos', 'DoctorController@getTratamientos');
        Route::post('guardarDiagnostico', 'DoctorController@guardarDiagnostico');
        Route::post('getDiente', 'DoctorController@getDiente');
        Route::put('asistencia/{id}', 'DoctorController@asistencia');
        Route::get('getDiagnosticos/{id}', 'DoctorController@getDiagnosticos');
        Route::post('nuevoDiagnostico', 'DoctorController@nuevoDiagnostico');
        Route::get('diagnosticoId/{id}', 'DoctorController@diagnosticoId');
        Route::post('editDiagnostico', 'DoctorController@editDiagnostico');


        Route::get('verDispo', 'ReceptionistController@verDispo');
        Route::get('verMedicos', 'ReceptionistController@verMedicos');
        Route::get('verConsultorios', 'ReceptionistController@verConsultorios');
        Route::get('verConsultas', 'ReceptionistController@verConsultas');
        Route::get('verDisponibilidades', 'ReceptionistController@verDisponibilidades');
        Route::post('createDispo','ReceptionistController@createDispo');
        Route::post('dispo','ReceptionistController@dispo');
        Route::put('editDispo/{id}','ReceptionistController@editDispo');
        Route::delete('destroy/{id}','ReceptionistController@destroy');
        Route::get('cita', 'ReceptionistController@cita');
        Route::get('getDispo', 'ReceptionistController@getDispo');
        Route::get('verPacientes', 'ReceptionistController@verPacientes');
        Route::get('buscarPaciente/{id}', 'ReceptionistController@buscarPaciente');
        Route::get('llamarFechas/{id}', 'ReceptionistController@llamarFechas');
        Route::post('guardarCita','ReceptionistController@guardarCita');
        Route::get('buscarCitaId/{id}', 'ReceptionistController@buscarCitaId');
        Route::get('estadoCitas', 'ReceptionistController@estadoCitas');
        Route::put('editarCita/{id}', 'ReceptionistController@editarCita');
        

        Route::get('verDocumento', 'AdministratorController@verDocumento');
        Route::get('verEstado' , 'AdministratorController@verEstado');
        Route::get('verTusuario' , 'AdministratorController@verTusuario');
        Route::get('buscarUsuario/{id}','AdministratorController@buscarUsuario');
        Route::post('editarUsuario','AdministratorController@editarUsuario');
        Route::post('dispoID','PatientController@dispoID');
        Route::put('cancelarCita/{id}','PatientController@cancelarCita');
        Route::get('listarTratamientos','AdministratorController@listarTratamientos');
        Route::get('listarSintomas','AdministratorController@listarSintomas');
        Route::post('crearTratamiento','AdministratorController@crearTratamiento');
        Route::post('crearSintomas','AdministratorController@crearSintomas');
        Route::put('actualizarTratamiento/{id}','AdministratorController@actualizarTratamiento');
        Route::put('actualizarSintoma/{id}','AdministratorController@actualizarSintoma');
        Route::post('buscarTratamiento','AdministratorController@buscarTratamiento');
        Route::post('buscarSintoma','AdministratorController@buscarSintoma');
        Route::delete('elimiarTratamiento/{id}','AdministratorController@elimiarTratamiento');
        Route::delete('elimiarSintoma/{id}','AdministratorController@elimiarSintoma');
        Route::put('actualizarUsuario/{id}','AdministratorController@actualizarUsuario');
    });
});

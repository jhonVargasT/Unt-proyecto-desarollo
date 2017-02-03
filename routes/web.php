<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/





Route::get('/',function(){
    return view('Index');
});

Route::resource('/loguear', 'personalController@loguearPersonal');
Route::resource('/cerrarSesion','personalController@logOutPersonal');
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////ADMINISTRADOR/////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/Adm', function () {
    return view('/Administrador/body');});

/////////////////Estudiante////////////////////////////
Route::get('/admRegistrarEstudiante', function () {
    return view('/Administrador/Alumno/Add');
});
Route::resource('AlumnoRegistrado', 'alumnoController@registrarAlumno');
Route::get('/admBuscarEstudiante', function () {
    return view('Administrador/Alumno/Search');
});
Route::get('EstudianteRegistrado', 'alumnoController@registrarAlumno');

Route::get('EstudianteEncontrado', 'alumnoController@buscarAlumno');


/////////////////////Cliente///////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarCliente', function () {
    return view('Administrador/Cliente/Add');
});

Route::get('/admBuscarCliente', function () {
    return view('Administrador/Cliente/Search');

});

Route::resource('ClienteRegistrado', 'clienteController@registrarCliente');


//////////////////////////////////////Donaciones//////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarDonaciones', function () {
    return view('Administrador/DonacionesYTransacciones/Add');
});

Route::get('/admBuscarDonaciones', function () {
    return view('Administrador/DonacionesYTransacciones/Search');
});

Route::resource('DonacionRegistrada', 'donacionController@registrarDonaciones');
Route::resource('DonacionTR', 'donacionController@llenar');

/////////////////////////////////////Escuela///////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarEscuela', function () {
    return view('Administrador/Escuela/Add');
});
Route::get('/admBuscarEscuela', function () {
    return view('Administrador/Escuela/Search');
});


Route::resource('EscuelaRegistrada', 'escuelaController@registrarEscuela');

////////////////////////////////// Facultad //////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarFacultad', function () {
    return view('Administrador/Facultad/Add');
});

Route::get('/admBuscarFacultad', function () {
    return view('Administrador/Facultad/Search');
});

Route::resource('FacultadRegistrada', 'facultadController@registrarFacultad');
Route::resource('FacultadesBuscadas', 'facultadController@listarFacultad');
Route::resource('FacultadCargar', 'facultadController@cargarFacultad');
Route::get('FacultadEditada/{idFacultad}', 'facultadController@editarFacultad');
Route::get('FacultadEliminar/{idFacultad}', 'facultadController@eliminarFacultad');
///////////////////////////////////Personal/////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarPersonal', function () {
    return view('Administrador/Personal/Add');
});


Route::get('admBuscarPersonal', function () {
    return view('Administrador/Personal/Search');
});

Route::resource('PersonalRegistrado', 'personalController@registrarPersonal');

///////////////////////////SubTramite/////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarSubtramite', function () {
    return view('Administrador/SubTramite/Add');
});


Route::get('/admBuscarSubtramite', function () {
    return view('Administrador/SubTramite/Search');
});

Route::resource('subTramiteRegistrado', 'subtramiteController@registrarSubtramite');

////////////////////////////////////Tramite////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarTramite', function () {
    return view('Administrador/Tramite/add');
});

Route::get('/admBuscarTramite', function () {
    return view('Administrador/Tramite/search');
});

Route::resource('TramiteRegistrado', 'tramiteController@registrarTramite');

/////////////////////////////////////Reporte///////////////////////////////////////////////////////////////////////////////////

Route::get('/admReportes', function () {
    return view('Administrador/Reporte/Report');
});




Route::get('autocompletee',array('as'=>'autocompletee','uses'=>'escuelaController@autocomplete'));
Route::get('autocomplete',array('as'=>'autocomplete','uses'=>'subtramiteController@autocomplete'));
Route::get('autocompletet',array('as'=>'autocompletet','uses'=>'donacionController@autocompletet'));

Route::post('/getmsg','donacionController@llenar');
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////Ventanilla ///////////////////////////
Route::get('/Vent', function () {
    return view('Ventanilla/Body');});
///////////////Cliente/////////////////////////
Route::get('/ventRegistrarCliente', function () {
    return view('Ventanilla/Cliente/Add');
});

Route::get('/ventBuscarCliente', function () {
    return view('Ventanilla/Cliente/Search');
});
//////////////Alumno//////////////////////////
Route::get('/ventRegistrarEstudiante', function () {
    return view('Ventanilla/Alumno/Add');
});

Route::get('/ventBuscarEstudiante', function () {
    return view('Ventanilla/Alumno/Search');
});
/////////////Pago////////////////////
Route::get('/ventRelizarPago', function () {
    return view('Ventanilla/Pagos/RealizarPago');
});
Route::get('/ventReportPago', function () {
    return view('Ventanilla/Pagos/ReportPago');
});
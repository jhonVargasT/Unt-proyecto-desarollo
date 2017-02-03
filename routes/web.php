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

Route::get('/Adm', function () {
    return view('/Administrador/body');
});
Route::get('/', function () {
    return view('index');
});


Route::resource('/loguear', 'personalController@loguearPersonal');
Route::resource('/cerrarSesion','personalController@logOutPersonal');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////ADMINISTRADOR/////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/Layout', function () {
    return view('Administrador/Body');
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/admRegistrarEstudiante', function () {
    return view('/Administrador/Alumno/Add');
});

Route::get('/admBuscarEstudiante', function () {
    return view('Administrador/Alumno/Search');
});

Route::resource('AlumnoRegistrado', 'alumnoController@registrarAlumno');
Route::resource('AlumnosBuscados', 'alumnoController@listarAlumno');
Route::resource('AlumnoCargar', 'alumnoController@cargarAlumno');
Route::get('AlumnoEditado/{codPersona}', 'alumnoController@editarAlumno');
Route::get('AlumnoEliminar/{codPersona}', 'alumnoController@eliminarAlumno');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarCliente', function () {
    return view('Administrador/Cliente/Add');
});
Route::get('/admBuscarCliente', function () {
    return view('Administrador/Cliente/Search');
});

Route::resource('ClienteRegistrado', 'clienteController@registrarCliente');
Route::resource('ClientesBuscados', 'clienteController@listarCliente');
Route::resource('ClienteCargar', 'clienteController@cargarCliente');
Route::get('ClienteEditado/{codPersona}', 'clienteController@editarCliente');
Route::get('ClienteEliminar/{codPersona}', 'clienteController@eliminarCliente');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarDonaciones', function () {
    return view('Administrador/DonacionesYTransacciones/Add');
});
Route::get('/admBuscarDonaciones', function () {
    return view('Administrador/DonacionesYTransacciones/Search');
});

Route::resource('DonacionRegistrada', 'donacionController@registrarDonaciones');
Route::resource('DonacionTR', 'donacionController@llenar');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarEscuela', function () {
    return view('Administrador/Escuela/Add');
});
Route::get('/admBuscarEscuela', function () {
    return view('Administrador/Escuela/Search');
});


Route::resource('EscuelaRegistrada', 'escuelaController@registrarEscuela');
Route::resource('EscuelasBuscadas', 'escuelaController@listarEscuela');
Route::resource('EscuelaCargar', 'escuelaController@cargarEscuela');
Route::get('EscuelaEditada/{idEscuela}', 'escuelaController@editarEscuela');
Route::get('EscuelaEliminar/{idEscuela}', 'escuelaController@eliminarEscuela');


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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarPersonal', function () {
    return view('Administrador/Personal/Add');
});
Route::get('admBuscarPersonal', function () {
    return view('Administrador/Personal/Search');
});

Route::resource('PersonalRegistrado', 'personalController@registrarPersonal');
Route::resource('PersonalBuscado', 'personalController@listarPersonal');
Route::resource('PersonalCargar', 'personalController@cargarPersonal');
Route::get('PersonalEditado/{codPersona}', 'personalController@editarPersonal');
Route::get('PersonalEliminar/{codPersona}', 'personalController@eliminarPersonal');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarSubtramite', function () {
    return view('Administrador/SubTramite/Add');
});
Route::get('/admBuscarSubtramite', function () {
    return view('Administrador/SubTramite/Search');
});

Route::resource('SubtramiteRegistrado', 'subtramiteController@registrarSubtramite');
Route::resource('SubtramitesBuscadas', 'subtramiteController@listarSubtramite');
Route::resource('SubtramiteCargar', 'subtramiteController@cargarSubtramite');
Route::get('SubtramiteEditada/{codSubtramite}', 'subtramiteController@editarSubtramite');
Route::get('SubtramiteEliminar/{codSubtramite}', 'subtramiteController@eliminarSubtramite');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarTramite', function () {
    return view('Administrador/Tramite/add');
});
Route::get('/admBuscarTramite', function () {
    return view('Administrador/Tramite/search');
});

Route::resource('TramiteRegistrado', 'tramiteController@registrarTramite');
Route::resource('TramitesBuscadas', 'tramiteController@listarTramite');
Route::resource('TramiteCargar', 'tramiteController@cargarTramite');
Route::get('TramiteEditada/{codTramite}', 'tramiteController@editarTramite');
Route::get('TramiteEliminar/{codTramite}', 'tramiteController@eliminarTramite');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admReportes', function () {
    return view('Administrador/Reporte/Report');
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////CLIENTE////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/Vent', function () {
    return view('Ventanilla/Body');
});
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


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('autocompletee', array('as' => 'autocompletee', 'uses' => 'escuelaController@autocompletee'));
Route::get('autocomplete', array('as' => 'autocomplete', 'uses' => 'subtramiteController@autocomplete'));
Route::get('autocompletet', array('as' => 'autocompletet', 'uses' => 'donacionController@autocompletet'));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
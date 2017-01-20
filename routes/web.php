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


Route::get('/', function () {
    return view('Index');
});

//Route::resource('/Tramite', 'personalController@loguearPersonal');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////ADMINISTRADOR/////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarEstudiante', function () {
    return view('/Administrador/Alumno/Add');
});
Route::resource('AlumnoRegistrado', 'alumnoController@registrarAlumno');

Route::get('/EditarEstudiante', function () {
    return view('Administrador/Alumno/Edit');
});

Route::get('/BuscarEstudiante', function () {
    return view('Administrador/Alumno/Search');
});
//Route::get('BuscarEstudiante', 'alumnoController@llenar');
//Route::get('BuscarEstudiante', 'alumnoController@llenarBSC');
//Route::get('/BuscarEstudiante', 'alumnoController@buscarAlumnoxDni');



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarCliente', function () {
    return view('Administrador/Cliente/Add');
});

Route::get('/EditarCliente', function () {
    return view('Administrador/Cliente/Edit');
});

Route::get('/BuscarCliente', function () {
    return view('Administrador/Cliente/Search');
});

Route::resource('ClienteRegistrado', 'clienteController@registrarCliente');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarDonacionesYTransacciones', function () {
    return view('Administrador/DonacionesYTransacciones/Add');
});

Route::get('/EditarDonacionesYTransacciones', function () {
    return view('Administrador/DonacionesYTransacciones/Edit');
});

Route::get('/BuscarDonacionesYTransacciones', function () {
    return view('Administrador/DonacionesYTransacciones/Search');
});

Route::resource('DonacionRegistrada', 'donacionController@registrarDonaciones');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarEscuela', function () {
    return view('Administrador/Escuela/Add');
});

Route::get('/EditarEscuela', function () {
    return view('Administrador/Escuela/Edit');
});

Route::get('/BuscarEscuela', function () {
    return view('Administrador/Escuela/Search');
});


Route::resource('EscuelaRegistrada', 'escuelaController@registrarEscuela');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarFacultad', function () {
    return view('Administrador/Facultad/Add');
});

Route::get('/EditarFacultad', function () {
    return view('Administrador/Facultad/Edit');
});

Route::get('/BuscarFacultad', function () {
    return view('Administrador/Facultad/Search');
});

Route::resource('FacultadRegistrada', 'facultadController@registrarFacultad');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarPersonal', function () {
    return view('Administrador/Personal/Add');
});

Route::get('/EditarPersonal', function () {
    return view('Administrador/Personal/Edit');
});

Route::get('/BuscarPersonal', function () {
    return view('Administrador/Personal/Search');
});

Route::resource('PersonalRegistrado', 'personalController@registrarPersonal');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarSubtramite', function () {
    return view('Administrador/SubTramite/Add');
});

Route::get('/Editarubtramite', function () {
    return view('Administrador/SubTramite/Edit');
});

Route::get('/BuscarSubtramite', function () {
    return view('Administrador/SubTramite/Search');
});

Route::resource('subTramiteRegistrado', 'subtramiteController@registrarSubtramite');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/RegistrarTramite', function () {
    return view('Administrador/Tramite/add');
});
Route::get('/EditarTramite', function () {
    return view('Administrador/Tramite/edit');
});
Route::get('/BuscarTramite', function () {
    return view('Administrador/Tramite/search');
});

Route::resource('TramiteRegistrado', 'tramiteController@registrarTramite');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////CLIENTE////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/Cliente/RegistrarEstudiante', function () {
    return view('Cliente/Alumno/Add');
});

Route::get('/Cliente/EditarEstudiante', function () {
    return view('Cliente/Alumno/Edit');
});

Route::get('/Cliente/BuscarEstudiante', function () {
    return view('Cliente/Alumno/Search');
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/Cliente/RegistrarCliente', function () {
    return view('Cliente/Cliente/Add');
});

Route::get('/Cliente/EditarEstudiante', function () {
    return view('Cliente/Cliente/Edit');
});

Route::get('/Cliente/BuscarEstudiante', function () {
    return view('Cliente/Cliente/Search');
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





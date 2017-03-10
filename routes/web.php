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
    return view('Administrador/Body');
});
Route::get('/', function () {
    return view('index');
});


Route::resource('/loguear', 'personalController@loguearPersonal');
Route::resource('/cerrarSesion', 'personalController@logOutPersonal');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////ADMINISTRADOR/////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/Layout', function () {
    return view('Administrador/Body');
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/admRegistrarEstudiante', function () {
    return view('Administrador/Alumno/Add');
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
Route::resource('DonacionesBuscadas', 'donacionController@listarDonaciones');
Route::resource('DonacionCargar', 'donacionController@cargarDonacion');
Route::get('DonacionEditada/{codDonacion}', 'donacionController@editarDonacion');
Route::get('DonacionEliminar/{codDonacion}', 'donacionController@eliminarDonacion');

////////////////////////////////////////////Escuela////////////////////////////////////////////////////////////////////////////

Route::get('/admRegistrarEscuela', function () {
    return view('Administrador/Escuela/Add');
});
Route::get('/admBuscarEscuela', function () {
    return view('Administrador/Escuela/search');
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

Route::resource('LlenarFacultad', 'facultadController@llenarFacultad');
Route::get('FacultadEditada/{idFacultad}', 'facultadController@editarFacultad');
Route::get('FacultadEliminar/{idFacultad}', 'facultadController@eliminarFacultad');
/////////////////////////////////////////////Personal///////////////////////////////////////////////////////////////////////////

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
    return view('Administrador/SubTramite/search');
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


//////////////////////////////////////////Rpoertepagos//////////////////////////////////////////////////////////////////////////////

Route::get('/admReportes', function () {
    return view('Administrador/Reporte/Report');
});
Route::resource('reportePago','pagoController@reportePagos');
//////////////////////////////////SEDE//////////////////////////////////////////////////////////////////////////////////
Route::get('/admRegistrarSede', function () {
    return view('Administrador/Sede/Add');
});
Route::get('/admBuscarSede', function () {
    return view('Administrador/Sede/Search');
});

Route::resource('SedeRegistrada', 'sedeController@registrarSede');
Route::resource('SedesBuscadas', 'sedeController@listarSede');
Route::resource('SedeCargar', 'sedeController@cargarSede');
Route::get('SedeEditada/{codSede}', 'sedeController@editarSede');
Route::get('SedeEliminar/{codSede}', 'sedeController@eliminarSede');


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

Route::get('/ventBoleta', function () {
    return view('Ventanilla/Pagos/boleta');
});

Route::resource('/pagar','pagoController@registrarPago');

Route::resource('PagosBuscados', 'pagoController@listarPago');
Route::get('PagoEliminar/{codPago}', 'pagoController@eliminarPago');
Route::get('PagoImprimir/{codPago}', 'PdfController@PagosBoletaAlumno');
Route::get('ventBoleta', 'PdfController@PagosBoleta');
Route::resource('datos', 'pagoController@obtenerDatos');

//Route::get('pdf/{txt}/{select}', 'PdfController@pdf');
Route::get('excel/{txt}/{select}','ExcelController@reportePago');
//Route::get('excel/{codPago}', 'PdfController@PagosBoletaAlumno');

Route::get('/buscarNombresD', 'pagoController@buscarNombresD');
Route::get('/buscarNombresDR', 'pagoController@buscarNombresDR');
Route::get('/buscarNombresC', 'pagoController@buscarNombresC');
Route::get('/buscarNombresR', 'pagoController@buscarNombresR');

Route::get('/buscarApellidosD', 'pagoController@buscarApellidosD');
Route::get('/buscarApellidosDR', 'pagoController@buscarApellidosDR');
Route::get('/buscarApellidosC', 'pagoController@buscarApellidosC');
Route::get('/buscarApellidosR', 'pagoController@buscarApellidosR');

Route::get('/buscarFacultadD', 'pagoController@buscarFacultadD');
Route::get('/buscarFacultadC', 'pagoController@buscarFacultadC');

Route::get('/buscarEscuelaD', 'pagoController@buscarEscuelaD');
Route::get('/buscarEscuelaC', 'pagoController@buscarEscuelaC');

Route::get('/precioSubtramite', 'pagoController@precioSubtramite');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('autocompletee', array('as' => 'autocompletee', 'uses' => 'escuelaController@autocompletee'));
Route::get('autocomplete', array('as' => 'autocomplete', 'uses' => 'subtramiteController@autocomplete'));
Route::get('autocompletet', array('as' => 'autocompletet', 'uses' => 'donacionController@autocompletet'));
Route::get('autocompletes', array('as' => 'autocompletes', 'uses' => 'pagoController@autocompletes'));
Route::get('autocompletesede', array('as' => 'autocompletesede', 'uses' => 'facultadController@autocompletesede'));
Route::get('escuela', array('as' => 'escuela', 'uses' => 'alumnoController@escuela'));
Route::get('/tipoRecurso', 'donacionController@tipoRecurso');
Route::get('/facultad', 'alumnoController@facultad');



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
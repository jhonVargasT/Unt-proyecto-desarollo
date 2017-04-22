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
Route::get('FacultadCargar/{idFacultad}', 'facultadController@cargarFacultad');
Route::get('FacultadEliminar/{idFacultad}', 'facultadController@eliminarFacultad');
Route::resource('autocomplete', 'facultadController@autocomplete');
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
Route::get('/admReportres', function () {
    return view('Administrador/Reporte/reporteresumido');
});

Route::resource('reportePago','pagoController@reportePagos');
Route::resource('admReporteresumido', 'pagoController@obtenerPagosresumen');
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

Route::get('/admImportarExcel', function () {
    return view('Administrador/Excel/import');
});

Route::resource('/pagar','pagoController@registrarPago');

Route::resource('importExcel', 'ExcelController@importExcel');

Route::resource('PagosBuscados', 'pagoController@listarPago');
Route::get('PagoEliminar/{codPago}', 'pagoController@eliminarPago');
Route::get('PagoImprimir/{codPago}/{estadoimprimir}', 'PdfController@PagosBoletaAlumno');
Route::get('PagoImprimirR/{codPago}/{estadoimprimir}', 'PdfController@PagosBoletaAlumnoR');

Route::get('PagoDeuda/{codPago}', 'pagoController@eliminarDeuda');
Route::get('ventBoleta', 'PdfController@PagosBoleta');
Route::resource('datos', 'pagoController@obtenerDatos');
Route::get('excelreportedet/{estado}/{modalidad}/{opctram}/{valtram}/{sede}/{facultad}/{escuela}/{tipre}/{fuefi}/{fechades}/{fechahas}','ExcelController@reportepagodetalle');
Route::get('excelresum/{tiporep}/{varopc}/{tiempo}/{numero}','ExcelController@reportePagoresu');
Route::get('exceldetallado/{encriptado}','ExcelController@reporteDetallado');
Route::get('excel/{txt}/{select}/{val}','ExcelController@reportePago');


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

Route::get('/nombreSCT', 'subtramiteController@nombreSCT');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('autocompletee', array('as' => 'autocompletee', 'uses' => 'escuelaController@autocompletee'));
Route::get('autocompletet', array('as' => 'autocompletet', 'uses' => 'donacionController@autocompletet'));
Route::get('autocompletes', array('as' => 'autocompletes', 'uses' => 'pagoController@autocompletes'));
Route::get('autocompletesede', array('as' => 'autocompletesede', 'uses' => 'facultadController@autocompletesede'));
Route::get('escuela', array('as' => 'escuela', 'uses' => 'alumnoController@escuela'));

Route::get('searchajax',array('as'=>'searchajax','uses'=>'alumnoController@autoComplete'));
Route::get('searchsedeescuela',array('as'=>'searchsedeescuela','uses'=>'escuelaController@autoCompleteEscuelaSede'));

Route::get('searchF',array('as'=>'searchF','uses'=>'facultadController@searchF'));
Route::get('searchE',array('as'=>'searchE','uses'=>'escuelaController@searchE'));

Route::get('/tipoRecurso', 'donacionController@tipoRecurso');
Route::get('/facultad', 'alumnoController@facultad');

Route::get('/obtenerDatos','pagoController@obtenerDatos');

Route::get('/banco','donacionController@banco');
////////////////////////CULQI///////////////////////////////////////////////////////////////////////////////////////////

Route::get('/pagoonline', function () {
    return view('Ventanilla/Culqi/pagoonline');
});
Route::post('pagoculqi', 'culqiController@culqi');
Route::get("autocompleteTram",array('as'=>'autocomplete','uses'=> 'tramiteController@autocompletar'));

/////////////////////////////////////////////////////REPORTE////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/repBuscarEstudiante', function () {
    return view('Reportes/Alumno/Search');
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/repBuscarCliente', function () {
    return view('Reportes/Cliente/Search');
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/repBuscarDonaciones', function () {
    return view('Reportes/DonacionYTransacciones/Search');
});

////////////////////////////////////////////Escuela/////////////////////////////////////////////////////////////////////

Route::get('/repBuscarEscuela', function () {
    return view('Reportes/Escuela/search');
});

////////////////////////////////// Facultad ////////////////////////////////////////////////////////////////////////////

Route::get('/repBuscarFacultad', function () {
    return view('Reportes/Facultad/Search');
});

/////////////////////////////////////////////Personal///////////////////////////////////////////////////////////////////

Route::get('/repBuscarPersonal', function () {
    return view('Reportes/Personal/Search');
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/repBuscarSubtramite', function () {
    return view('Reportes/SubTramite/search');
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/repBuscarTramite', function () {
    return view('Reportes/Tramite/search');
});
//////////////////////////////////////////Rpoertepagos//////////////////////////////////////////////////////////////////

Route::get('/repReportes', function () {
    return view('Reportes/Reporte/Report');
});
Route::get('/repReportesResumido', function () {
    return view('Reportes/Reporte/reporteresumido');
});
//////////////////////////////////SEDE//////////////////////////////////////////////////////////////////////////////////

Route::get('/repBuscarSede', function () {
    return view('Reportes/Sede/Search');
});

//////////////////////////////////Pagos/////////////////////////////////////////////////////////////////////////////////

Route::get('/repBuscarPagos', function () {
    return view('Reportes/Pagos/ReportPago');
});


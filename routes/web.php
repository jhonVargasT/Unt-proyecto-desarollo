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
    return view('LayoutAdm');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/personal', function () {
    return view('Administrador/personal');
});

Route::get('/Index', function () {
    return view('Index');
});

Route::resource('/Index','personalController@loguearPersonal');
Route::resource('/registrado','personalController@registrarPersonal');




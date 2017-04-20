<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//recibir imagen que queremos identificar desde la app
//se envia la imagen a clarifai y nos devuelve los conceptos de la imagen
Route::get('prueba', 'ClariController@enviarImagenClarifai');
//
Route::post('recognitionimage', 'ClariController@recibirConcepto');

Route::post('pruebapp', 'ClariController@recibirImagen');

Route::get('pruebapp2', 'ClariController@recibirImagen2');

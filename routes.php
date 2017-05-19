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

Route::get('prueba', 'ClariController@enviarImagenClarifai');
//
Route::post('recognitionimage', 'ClariController@recibirConcepto');

Route::post('pruebapp', 'ClariController@recibirImagen');

Route::get('pruebapp2', 'ClariController@recibirImagen2');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('panel.layout');
    });

    Route::get('/concepts', 'AdminController@conceptos');
    Route::post('/store', 'AdminController@store');
    Route::get('/concepts/crear', 'AdminController@create');
    Route::post('/concepts/delete', 'AdminController@destroy');
    Route::get('/concepts/{id}/{status}', 'AdminController@changeStatus');
    Route::get('/editar/concepts/{id}', 'AdminController@edit');
    Route::post('/update', 'AdminController@update');

    Route::resource('/users', 'UsersController');
    Route::post('/users/edit', 'UsersController@updateUser');
    Route::post('/users/delete', 'UsersController@deleteUser');
});


Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
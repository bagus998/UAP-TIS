<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'uap'], function () use ($router) {
    // Rute tanpa otentikasi
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');

    // Rute yang memerlukan otentikasi JWT
    $router->group(['middleware' => 'jwt'], function () use ($router) {
        // Mahasiswa
        $router->get('/mahasiswa', 'MahasiswaController@index');
        $router->get('/mahasiswa/prodi/{id}', 'MahasiswaController@filterByProdi');

        // Prodi
        $router->get('/prodi', 'ProdiController@index');

        // Matakuliah
        $router->get('/matkul', 'MatkulController@index');
        $router->post('/matkul/tambah', 'MatkulController@tambah');
        $router->get('/matkul/saya', 'MatkulController@lihat'); // Mengubah {id} menjadi rute spesifik
    });
});
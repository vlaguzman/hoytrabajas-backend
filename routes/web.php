<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/paises', ['uses' => 'PaisController@listar']);



Route::resource('generos', 'GeneroController');

Route::resource('sectors', 'SectorController');

Route::resource('idiomas', 'IdiomaController');

Route::resource('estudios', 'EstudioController');

Route::resource('pais', 'PaisController');

Route::resource('departamentos', 'DepartamentoController');

Route::resource('empleadors', 'EmpleadorController');

Route::resource('ofertas', 'OfertaController');

Route::resource('candidatos', 'CandidatoController');

Route::resource('sectorCandidatos', 'SectorCandidatoController');

Route::resource('estudiosCandidatos', 'EstudiosCandidatoController');

Route::resource('idiomasCandidatos', 'IdiomasCandidatoController');

Route::resource('postulacions', 'PostulacionController');

Route::resource('membresiaPrecios', 'MembresiaPrecioController');

Route::resource('membresiaCandidatos', 'MembresiaCandidatoController');

Route::resource('membresiaEmpleadors', 'MembresiaEmpleadorController');

Route::resource('mensajes', 'MensajesController');

Route::resource('alertas', 'AlertasController');
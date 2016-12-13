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

/*listas de datos */
Route::get('paises','PaisController@listar' );
Route::any('departamentos', 'DepartamentoController@listar');
Route::any('ciudades', 'CiudadController@listar');
Route::any('generos', 'GeneroController@listar');
Route::any('estudios', 'EstudioController@listar');
Route::any('idiomas', 'IdiomaController@listar');
Route::any('sectores', 'SectorController@listar');
Route::any('ofertas', 'OfertaController@listar');
Route::any('usuarios', 'CandidatoController@listar');
/* fin listas */
Route::any('loginm', 'UsuarioController@login');
Route::any('registraru2', 'UsuarioController@registrar2');
Route::any('registraru3', 'UsuarioController@registrar3');
Route::any('regoferta', 'OfertaController@registrar');

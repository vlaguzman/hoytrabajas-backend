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

//Route::group(['prefix'=>'api/v1'] , function () {
	/*listas de datos */
	Route::get('paises','PaisController@listar' );
	Route::any('departamentos', 'DepartamentoController@listar');
	Route::any('ciudades', 'CiudadController@listar');
	Route::any('generos', 'GeneroController@listar');
	Route::any('estudios', 'EstudioController@listar');
	Route::any('idiomas', 'IdiomaController@listar');
	Route::any('sectores', 'SectorController@listar');
	Route::any('ofertasactivas', 'OfertaController@listara');
	Route::any('ofertasvencidas', 'OfertaController@listarb');
	Route::any('buscarcandidato', 'CandidatoController@listar');
	Route::any('postulaciones', 'PostulacionController@listar');
	Route::any('postulacionempleadores', 'PostulacionController@empleadores');
	Route::any('postulacionusuarios', 'PostulacionController@usuarios');
	Route::any('postulacionpendientes', 'PostulacionController@upendientes');
	Route::any('postulacionaceptadas', 'PostulacionController@uaceptadas');
	Route::any('postulacionrechazadas', 'PostulacionController@urechazadas');
	
	Route::any('historicomensajes', 'MensajesController@listar');
	/* fin listas */
	/* gets */
	
	Route::any('getdetusuario', 'UsuarioController@detallesuario');
	Route::any('getdetoferta', 'OfertaController@getofertaa');
	Route::any('getdetcandidato', 'CandidatoController@getcandidatoa');
	Route::any('verificarmembresia', 'MembresiaCandidatoController@verificar');
	Route::any('verificarpostulacion', 'PostulacionController@verificar');
	Route::any('getcandidatodetalle', 'CandidatoController@getcandidatodetalle');
	Route::any('getempresa', 'EmpleadorController@getempleador');
	Route::any('getempresadetalle', 'EmpleadorController@getdetalle');
	/* fin gets*/
	Route::any('loginm', 'UsuarioController@login');
	Route::any('loginrs', 'UsuarioController@login_byemail');
	Route::any('registrarurs', 'UsuarioController@registrarrs');
	Route::any('registraru2', 'UsuarioController@registrar2');
	Route::any('registraru2rs', 'UsuarioController@registrar2rs');
	Route::any('registraru3', 'UsuarioController@registrar3');
	Route::any('registraru3rs', 'UsuarioController@registrar3rs');
	Route::any('regoferta', 'OfertaController@registrar');
	Route::any('regpostulacion', 'PostulacionController@registrar');
	Route::any('regpostulaciona', 'PostulacionController@aprobar');
	Route::any('regpostulacionr', 'PostulacionController@rechazar');
	Route::any('regmembresia', 'MembresiaCandidatoController@registrar');
	Route::any('regmensaje', 'MensajesController@registrar');
	

//});
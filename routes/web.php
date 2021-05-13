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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

Route::get('opportunities', 'OpportunityController@index');

Route::resource('encuesta', 'EncuestaController');

Route::get('files_upload', 'FilesController@index');

Route::get('upload_csv', 'FileController@index');

Route::get('agenda', 'AgendaController@index');

Route::get('estadistica', 'EstadisticaController@index');

Route::get('pedido', 'PedidoController@index');

Route::post('buscarMaterial', 'PedidoController@consultarMaterial');

Route::post('guardarOC', 'PedidoController@guardarOrden');

Route::post('obtenerDistribuidores', 'PedidoController@obtenerDistribuidores');

Route::post('guardarOportunidad', 'PedidoController@guardarOportunidades');

Route::post('obtenerOportunidades', 'OpportunityController@obtenerOportunidades');

Route::post('obtenerOportunidadesLista', 'OpportunityController@obtenerOportunidadesOrden');

Route::get('seguimientoOrden', 'OrderManagementController@index');

Route::post('obtenerOC', 'OrderManagementController@obtenerOrden');

Route::post('obtenerDetalleOC', 'OrderManagementController@obtenerDetalleOrden');

Route::post('obtenerProspectosPGC', 'PedidoController@obtenerProspectosPGC');

Route::post('obtenerCatalogoPGC', 'PedidoController@CatalogoProductos');

Route::post('guardarNuevoProspecto', 'OpportunityController@nuevoProspecto');

});

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

Route::post('guardarEncuesta', 'EncuestaController@store');

Route::get('files_upload', 'FilesController@index');

Route::get('upload_csv', 'FileController@index');

Route::get('agenda', 'AgendaController@index');

Route::get('estadistica', 'EstadisticaController@index');

Route::get('pedido', 'PedidoController@index');

Route::post('buscarMaterial', 'PedidoController@consultarMaterial');

Route::post('guardarOC', 'PedidoController@guardarOrden');

Route::post('obtenerDistribuidores', 'PedidoController@obtenerDistribuidores');

Route::post('guardarOportunidad', 'FileController@guardarOportunidades');

Route::post('subirCSVOportunidad', 'FileController@subirCSVOportunidad');

Route::post('obtenerOportunidades', 'OpportunityController@obtenerOportunidades');

Route::post('obtenerOportunidadesLista', 'OpportunityController@obtenerOportunidadesOrden');

Route::get('seguimientoOrden', 'OrderManagementController@index');

Route::post('obtenerOC', 'OrderManagementController@obtenerOrden');

Route::post('obtenerDetalleOC', 'OrderManagementController@obtenerDetalleOrden');

Route::post('obtenerProspectosPGC', 'PedidoController@obtenerProspectosPGC');

Route::post('obtenerCatalogoPGC', 'PedidoController@CatalogoProductos');

Route::post('guardarNuevoProspecto', 'OpportunityController@nuevoProspecto');

Route::post('darBajaOportunidad', 'OpportunityController@oportunidadCancelada');

Route::post('buscarDistribuidores', 'PedidoController@buscarDistribuidores');

Route::post('cargarCorreoDistribuidor', 'OrderManagementController@obtenerInfoDistribuidor');

Route::post('enviarDetalleOC', 'OrderManagementController@envioOrdenEmail');

Route::get('gestorRuta', 'RutasController@index');

Route::post('obtenerRutaLista', 'RutasController@obtenerListadoRuta');

Route::post('obtenerRuta', 'RutasController@obtenerRuta');

Route::get('gestorProspectos', 'ProspectoController@index');

Route::post('obtenerProspectos', 'ProspectoController@obtenerProspecto');

Route::post('obtenerResultadosEncuesta', 'EncuestaController@show');

/**
 * Inicio y bitacora de Rutas
 */
Route::post('buscarRutaIniciada', 'RutasController@buscarRutaIniciada');
Route::post('iniciarRuta', 'RutasController@iniciarRuta');
Route::post('pausarRuta', 'RutasController@pausarRuta');
});

/*-----------------------------------------------------
---------  Rutas de agenda para vendedor PGC ---------*/
Route::get('obtenerFecha_actual', 'AgendaVendedorController@fecha_actual');

Route::post('agendaNuevaCita', 'AgendaVendedorController@GuardarCita');
Route::post('agendaConcentradoCita', 'AgendaVendedorController@ConcentradoCita');
Route::post('agendaBorrarCita', 'AgendaVendedorController@BorrarCita');

Route::post('obtenerEvidenciaCita', 'AgendaVendedorController@obtenerEvidenciaCita');

Route::post('agendaActivarCheckIn', 'AgendaVendedorController@ActivarCheckIn');

Route::post('agendaConcentradoCheckIn', 'AgendaVendedorController@ConcentradoCheckIn');

Route::post('agendaActivarCheckOut', 'AgendaVendedorController@ActivarCheckOut');

Route::post('agendaActivarFinalizo', 'AgendaVendedorController@ActivarFinalizarTarea');

Route::post('agendaContadorCitasDiaHoy', 'AgendaVendedorController@ContadorCitasDiaHoy');

Route::post('agendaContadorCitasPendientes', 'AgendaVendedorController@ContadorCitasPendientes');

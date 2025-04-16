<?php

use Api\AuthApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('getUser/token/{token}/id/{id}',[\Api\testApi::class,'test']);


/*- --- API @Pedro Leão ---- */

//// Gráficos ////////////
//////////////////////////
Route::get('/faturamento/{idCliente}/total/{data_inicio?}/{data_fim?}', [Api\controllers\C_graficos::class, 'getTotalFaturamento']);
Route::get('/paginas/{idCliente}/mes/{data_fim?}', [Api\controllers\C_graficos::class, 'getPaginasMês']);
Route::get('/chamados/{idCliente}/{data_inicio?}/{data_fim?}', [Api\controllers\C_graficos::class, 'getChamadosGraph']);
Route::get('/sla-percentual/{idCliente}/{periodo_inicio?}/{periodo_fim?}', [Api\controllers\C_graficos::class, 'getSLADentroPercent']);

//////////////////////////
//// Autenticação ////////
Route::post('/login', [Api\controllers\C_login::class, 'login']);

//////////////////////////
//// Inventário //////////
Route::get('/inventario', [Api\controllers\C_inventario::class, 'getInventario']);
Route::get('/inventario/{id}', [Api\controllers\C_inventario::class, 'getInventarioDetails']);

//////////////////////////
//// Faturamento /////////
Route::get('/faturamento', [Api\controllers\C_faturamento::class, 'getFaturamento']);
Route::get('/faturamento/{id}', [Api\controllers\C_faturamento::class, 'getDetailsFaturamento']);
Route::get('/faturamento/total', [Api\controllers\C_faturamento::class, 'getDashFaturamento']);
Route::post('/faturamento/{id}/update/upload', [Api\controllers\C_faturamento::class, 'uploadInvoice']);

//////////////////////////
//// Notícias ////////////
Route::get('/noticias', [Api\controllers\C_noticias::class, 'getAllNews']);
Route::post('/noticias/resgistrar', [Api\controllers\C_noticias::class, 'registerNews']);
Route::post('/noticias/{id}/acao', [Api\controllers\C_noticias::class, 'newsAction']);
Route::post('/noticias/{id}/deletar', [Api\controllers\C_noticias::class, 'deleteNews']);
Route::post('/noticias/{id}/desativar', [Api\controllers\C_noticias::class, 'deactivateNews']);

//////////////////////////
//// Chamados ////////////
Route::get('/chamados', [Api\controllers\C_chamados::class, 'getChamados']);
Route::get('/chamados-dashboard', [Api\controllers\C_chamados::class, 'getDashboardChamados']);
Route::post('/chamados/update/upload', [Api\controllers\C_chamados::class, 'uploadChamados']);

//////////////////////////
//// Rastreio ////////////
Route::get('/rastreio', [Api\controllers\C_rastreio::class, 'getTracking'])->middleware('auth');
Route::get('/rastreio/{id}', [Api\controllers\C_rastreio::class, 'getTrackingDetails'])->middleware('auth');

//////////////////////////
//// Notícias ////////////
Route::get('/noticias', [Api\controllers\C_noticias::class, 'dashboard']);
Route::post('/noticias/create', [Api\controllers\C_noticias::class, 'registerNews']);
Route::post('/noticias/{id}/desativar', [Api\controllers\C_noticias::class, 'deactivateNews']);
Route::post('/noticias/{id}/delete', [Api\controllers\C_noticias::class, 'deleteNews']);

//////////////////////////
//// Notificações ////////
Route::get('/notificacoes', [Api\controllers\C_notificacoes::class, 'getNotifications']);
Route::post('/notificacoes/create', [Api\controllers\C_notificacoes::class, 'addNewNotification']);
Route::post('/notificacoes/{id}/update/desativar', [Api\controllers\C_notificacoes::class, 'disableNotification']);

//////////////////////////
//// Usuários ////////////
Route::get('/usuarios/create', [Api\controllers\C_usuarios::class, 'newUser']);
Route::post('/usuarios/{id}/update', [Api\controllers\C_usuarios::class, 'updateUser']);
Route::post('/usuarios/{id}/update/senha', [Api\controllers\C_usuarios::class, 'registerUserPassword']);
Route::get('/usuarios/{token}', [Api\controllers\C_usuarios::class, 'checkUserToken'])->name('user-token');
Route::post('/usuarios/{id}/recover/senha', [Api\controllers\C_usuarios::class, 'recoverPassword']);
Route::get('/usuarios/filter', [Api\controllers\C_usuarios::class, 'filterUsers']);

//////////////////////////
//// Clientes ////////////
Route::get('/clientes', [Api\controllers\C_clientes::class, 'index']);
Route::get('/clientes/userlist', [Api\controllers\C_clientes::class, 'getClienteUserList']); //??
Route::get('/clientes/{id}/usuarios', [Api\controllers\C_clientes::class, 'getUsersFromCliente']); //??
Route::post('/clientes/{id}/update/ativar', [Api\controllers\C_clientes::class, 'ActiveClientes']);
Route::post('/clientes/{id}/update/desativar', [Api\controllers\C_clientes::class, 'DeactiveClientes']);
Route::post('/clientes/{id}/update/logo', [Api\controllers\C_clientes::class, 'UpdateLogoClientes']);
Route::delete('/clientes/{id}/delete', [Api\controllers\C_clientes::class, 'RemoveClientes']);
Route::get('/clientes/filters', [Api\controllers\C_clientes::class, 'filterClientes']);

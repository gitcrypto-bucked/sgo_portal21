<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\AutoTimeout;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




Route::middleware('auth',PreventBackHistory::class)->group(function ()
{
    Route::match(['get'],'/logout','\App\Http\Controllers\LoginController@userLogout')->name('logout');
});


Route::middleware('auth',AutoTimeout::class)->group(function ()
{
    Route::match(['get'], '/list-news','\App\Http\Controllers\NewsController@dashboard')->name('list-news');

    Route::match(['get'],'/add_news','\App\Http\Controllers\NewsController@add_News')->name('add_news');

    Route::match(['post'],'/register_news','\App\Http\Controllers\NewsController@registerNews')->name('register_news');

    Route::match(['get'],'/news-manager','\App\Http\Controllers\NewsController@newsManager')->name('news-manager');

    Route::match(['post'],'/news-action','\App\Http\Controllers\NewsController@newsAction')->name('newsAction');

    Route::match(['get'],'/new_user','\App\Http\Controllers\UserController@newUser')->name('new_user');

    Route::match(['post'],'/add_user','\App\Http\Controllers\UserController@createNewUser')->name('add_user');

    Route::match(['get'],'/invoice-upload','\App\Http\Controllers\Invoice@index')->name('invoice-upload');

    Route::match(['post'],'/upload-invoice','\App\Http\Controllers\Invoice@uploadInvoice')->name('uploadInvoice');

    Route::match(['get'],'/chamados-upload','\App\Http\Controllers\Chamados@index')->name('chamados-upload');

    Route::match(['post'],'/upload-chamados','\App\Http\Controllers\Chamados@uploadChamados')->name('upload-chamados');

    Route::match(['get'],'/cliente_manager','\App\Http\Controllers\ClienteController@index')->name('cliente_manager');

    Route::match(['post', 'get'],'/filter_clientes', '\App\Http\Controllers\ClienteController@filterClientes')->name('filter-clientes');

    Route::match(['post'],'/remove-clientes', '\App\Http\Controllers\ClienteController@RemoveClientes')->name('remove-clientes');

    Route::match(['post'],'/active-clientes', '\App\Http\Controllers\ClienteController@ActiveClientes')->name('active-clientes');

    Route::match(['post'],'/disable-clientes', '\App\Http\Controllers\ClienteController@DeactiveClientes')->name('disable-clientes');

    Route::match(['post'],'/update-logo-clientes', '\App\Http\Controllers\ClienteController@UpdateLogoClientes')->name('update-logo-clientes');

    Route::match(['get'],'/cliente_manager','\App\Http\Controllers\ClienteController@index')->name('cliente_manager');

    Route::match(['get'],'/usuarios_clientes','\App\Http\Controllers\ClienteController@getUsersFromCliente')->name('usuarios_clientes');

    Route::match(['post', 'get'],'/filter_users', '\App\Http\Controllers\UserController@filterUsers')->name('filter-users');

    Route::match(['get'],'/inventario','App\Http\Controllers\Inventario@getInventario')->name('inventario');

    Route::match(['get'],'/faturamento','App\Http\Controllers\Invoice@getFaturamento')->name('faturamento');

    Route::match(['get'],'/faturamento_details','App\Http\Controllers\Invoice@getDetailsFaturamento')->name('faturamento_details');

    Route::match(['get','post'],'/dash_faturamento','App\Http\Controllers\DashController@getDashboardFaturamento')->name('dash_faturamento');

    Route::match(['get','post'],'/dash_chamados', "App\Http\Controllers\DashController@getDashboardChamados")->name('dash_chamados');

    Route::match(['get'],'/inventario_details','App\Http\Controllers\Inventario@getInventarioDetails')->name('inventario_details');

    Route::match(['get'],'/chamados','App\Http\Controllers\Chamados@getChamados')->name('chamados');

    Route::match(['get'], 'dash_inventario',function (){  return view('dashboard_inventario');})->name('dash_inventario');

    Route::match (['get'],'/chamados_details','App\Http\Controllers\Chamados@getChamadoDetalhe')->name('chamados_details');

    Route::match(['get','post'],'/busca_invetario','App\Http\Controllers\SearchController@buscaInventario')->name('busca_invetario');

    Route::match(['get','post'],'/busca_invetario_detalhado','App\Http\Controllers\SearchController@buscaInventarioDetalhado')->name('busca_invetario_detalhado');

    Route::match(['get'],'/tracking', 'App\Http\Controllers\TrackingController@getTracking')->name('tracking');

    Route::match(['get'],'/tracking_details', 'App\Http\Controllers\TrackingController@getTrackingDetails')->name('tracking_details');

    Route::match(['get'],'/abrir_chamado','App\Http\Controllers\Chamados@abrirChamados')->name('abrir_chamado');

    Route::match(['post'],'/update_chamado','App\Http\Controllers\Chamados@addFollowUP')->name('update_chamado');

    Route::match(['post'],'/novo_chamado','App\Http\Controllers\Chamados@novoChamados')->name('novo_chamado');

    Route::match(['get'],'/detalhes_mobile','App\Http\Controllers\Inventario@getDetalhesMobile')->name('detalhes_mobile');

    Route::match(['get'],'/trocar_tela','App\Http\Controllers\UserController@trocarTela')->name('trocar_tela');

    Route::match(['get'],'/switch_back','App\Http\Controllers\UserController@switchBack')->name('switch_back');

    Route::match(['get'],'/active_user','App\Http\Controllers\UserController@activeUser')->name('active_user');

    Route::match(['get'],'/deactive_user','App\Http\Controllers\UserController@deactiveUser')->name('deactive_user');

    Route::match(['get'],'/delete_user','App\Http\Controllers\UserController@deleteUser')->name('delete_user');

    Route::match(['get'],'/dash', 'App\Http\Controllers\DashController@postLogin')->name('dash');

});

Route::middleware('guest')->group(function ()
{
    Route::match(['get'], '/', function () {return view('login');});

    Route::match(['get'], '/login', function () {return view('login');})->name('login');

    Route::match(['get'], '/forgot-password', function (){ return view('forgot-password');})->name('forgot-password');

    Route::match(['post'],'/userLogin', '\App\Http\Controllers\LoginController@userLogin')->name('userLogin');

    Route::match(['get'],'/token','\App\Http\Controllers\UserController@checkUserToken')->name('user-token');//{token}

    Route::match(['post'],'/recover-password','\App\Http\Controllers\UserController@recoverPassword')->name('recoverPassword');

    Route::match(['post'],'/update-password','\App\Http\Controllers\UserController@registerUserPassword')->name('updatePassword') ;

    Route::match(['get'],'/impressao-contadores', 'App\Http\Controllers\Inventario@getTotais')->name('impressao-contadores');




});

Route::match(['get'],'/expired_link',function (){ return view('expired-link');})->middleware('guest',PreventBackHistory::class)->name('expired-link');

Route::match(['get'],'/suprimentos_detalhe','App\Http\Controllers\Inventario@getSuprimentos')->name('suprimentos_detalhe');

Route::match(['get'],'/monitoramento_detalhe','App\Http\Controllers\Inventario@getMonitoramentos')->name('monitoramento_detalhe');

Route::match(['get'],'/monitoramento_grafico', 'App\Http\Controllers\Inventario@getContatores')->name('monitoramento_grafico');

Route::match(['get'], '/list-notifications', '\App\Http\Controllers\NotificationController@getNotifications')->name('list-notifications');

Route::match(['post'], '/remove-notification', '\App\Http\Controllers\NotificationController@disableNotification')->name('remove-notification');

Route::match(['post'],'/chamados-rating','\App\Http\Controllers\Chamados@setRating')->name('chamados-rating');

Route::match(['post'],'/cliente_color','\App\Http\Controllers\ClienteController@setColor')->name('cliente_color');

Route::match(['post'],'/faturamento-detalhes','App\Http\Controllers\Invoice@getFaturamentoDetalhesEquipamento')->name('faturamento-detalhes');
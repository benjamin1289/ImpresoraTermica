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
    return 'API';//view('welcome');
});

Route::get('/api', function () {
    return '    Impresora';//view('welcome');
});

Route::group(['prefix' => 'print'], function(){
    
    Route::get('/test', 'printerController@printertest');

	Route::get('/ticket', 'printerController@imprimeticket');
	
    Route::get('/testip', 'printerController@printertestip');
    
    Route::get('/ticketip', 'printerController@imprimeticketip');

});

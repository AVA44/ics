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
    return view('seed');
});

// 景品情報操作系
Route::resource('inventory', 'InventoryController');
Route::post('/ajax', 'InventoryController@ajax');

// 在庫情報操作系
Route::get('/addStock', 'StockController@addStockForm')->name('stock.addForm');
Route::post('/addStock', 'StockController@addStock');
Route::get('/addStockConfilm', 'StockController@addStockConfilm')->name('stock.addConfilm');
Route::get('/useStock', 'StockController@useStockForm')->name('stock.useForm');
Route::post('/useStock', 'StockController@useStock');
Route::get('/useStockConfilm', 'StockController@useStockConfilm')->name('stock.useConfilm');
Route::post('/choiceStockDestroy', 'StockController@choiceStockDestroy')->name('stock.choiceDestroy');
Route::post('/absentStockDestroy', 'StockController@absentStockDestroy')->name('stock.absentDestroy');

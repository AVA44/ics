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
Route::post('/addStock', 'StockController@addStock')->name('stock.add');
Route::post('/addStockConfilm', 'StockController@addStockConfilm')->name('stock.addConfilm');
Route::post('/useStock', 'StockController@useStock')->name('stock.use');
Route::post('/useStockConfilm', 'StockController@useStockConfilm')->name('stock.useConfilm');
Route::post('/stockDestroy', 'StockController@stockDestroy')->name('stock.destroy');

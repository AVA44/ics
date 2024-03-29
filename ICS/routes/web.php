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
Route::get('/addStock', 'StockDataController@addStockForm')->name('stock.addForm');
Route::post('/addStock', 'StockDataController@addStock');
Route::get('/useStock', 'StockDataController@useStockForm')->name('stock.useForm');
Route::post('/useStock', 'StockDataController@useStock');
Route::get('/inventoryDestroy', 'InventoryController@destroyForm')->name('inventory.destroyForm');
Route::post('/inventoryDestroy', 'InventoryController@destroy')->name('inventory.destroy');

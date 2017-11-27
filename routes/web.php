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

Route::get('home', 'HomeController@index')->name('home');
Route::get('product/add', 'productController@addui');
Route::get('product/edit/stock', 'productController@stockui');
Route::get('sale', 'saleController@home');
Route::get('bill/{billno}', 'pdfController@home');
Route::get('print/{billno}', 'pdfController@print');
Route::get('exchange/{billno}', 'exchangeController@home');
Route::get('exchange/remove/{exid}', 'exchangeController@remove');
Route::get('product/view', 'viewController@product');
Route::get('sale/view', 'viewController@sale');
Route::get('search', 'searchController@bill');
Route::get('report', 'reportController@report');


#Form submission routes
Route::post('product/add/new', 'productController@add');
Route::post('product/add/update/stock', 'productController@stock');
Route::post('sale/add', 'saleController@add');
Route::post('sale/complete', 'saleController@complete');
Route::post('sale/exchange/add', 'exchangeController@add');
Route::post('exchange/complete', 'exchangeController@complete');
Route::post('bill/check/', 'searchController@findbill');
Route::post('report/download/', 'reportController@download');

#Ajax routes
Route::get('product/add/check/{code}', 'productController@check');
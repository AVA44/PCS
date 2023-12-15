<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\PrizeController;

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
    return view('prize_index');
});

Route::get('/getPrizeJsonData', [PrizeController::class, 'GetPrizeJsonData'])->name('getPrizeJsonData');
Route::get('/getStockJsonData', [PrizeController::class, 'GetStockJsonData'])->name('getStockJsonData');
Route::get('/create', function () {
    return view('prize_create');
});
Route::get('/detail/{id}', [PrizeController::class, 'PrizeDetail'])->name('prizeDetail');
Route::get('/delete', [PrizeController::class, 'PrizeDelete'])->name('prizeDelete');
Route::post('/create', [PrizeController::class, 'PrizeCreate'])->name('prizeCreate');
Route::post('/destroy', [PrizeController::class, 'PrizeDestroy'])->name('prizeDestroy');
Route::post('/stockAdd', [PrizeController::class, 'StockAdd'])->name('stockAdd');
Route::post('/stockEdit', [PrizeController::class, 'StockEdit'])->name('stockEdit');
Route::post('/stockDelete', [PrizeController::class, 'StockDelete'])->name('stockDelete');

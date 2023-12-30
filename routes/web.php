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
Route::get('/', function() {
    return view('template');
});
Route::get('/index', function () {
    return view('prize_index');
});
Route::get('/create', function () {
    return view('prize_create');
});
Route::get('/delete', function() {
    return view('prize_delete');
});
Route::get('/detail/{id}', [PrizeController::class, 'GetPrizeDetail'])->name('prizeDetail');

Route::get('/getPrizeJsonData', [PrizeController::class, 'GetPrizeJsonData'])->name('getPrizeJsonData');
Route::get('/getStockJsonData', [PrizeController::class, 'GetStockJsonData'])->name('getStockJsonData');

Route::post('/create', [PrizeController::class, 'PostPrizeCreate'])->name('prizeCreate');
Route::post('/delete', [PrizeController::class, 'PostPrizeDelete'])->name('prizeDelete');
Route::post('/stockAdd', [PrizeController::class, 'PostStockAdd'])->name('stockAdd');
Route::post('/stockEdit', [PrizeController::class, 'PostStockEdit'])->name('stockEdit');
Route::post('/stockDelete', [PrizeController::class, 'PostStockDelete'])->name('stockDelete');

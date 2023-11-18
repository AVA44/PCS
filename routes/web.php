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
Route::get('/create', function () {
    return view('prize_create');
});
Route::post('/create', [PrizeController::class, 'PrizeCreate'])->name('prizeCreate');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gen_CancelContract;
use App\Http\Controllers\PAYCOLLECT_PENALTY;

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
    // return view('welcome');
    return view('cancelContract');
});


Route::get('/cancelContract', function () {
    return view('cancelContract');
});


Route::get('/discount', function () {
    return view('discount');
});


Route::get('/PAYCOLLECT_PENALTY', function () {
    return view('PAYCOLLECT_PENALTY');
});


Route::post('post_CancelContract', [Gen_CancelContract::class, 'main_void']);

Route::post('post_PAYCOLLECT_PENALTY', [PAYCOLLECT_PENALTY::class, 'main_void']);
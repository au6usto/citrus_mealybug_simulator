<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/random/{amount}/{seed}', 'PseudoRandomNumberController@getNumbers');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/simulador', 'HomeController@simulador')->name('simulador');
Route::get('/resultado-simulador', 'HomeController@simuladorResults')->name('simulador_results');

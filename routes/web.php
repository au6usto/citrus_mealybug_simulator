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

Route::get('/random', 'PseudoRandomNumberController@getNumbers')->name('random');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home2');
Route::get('/simulador', 'HomeController@simulador')->name('simulador');
Route::get('/simulador_prototype', 'HomeController@simuladorPrototype')->name('simulador_prototype');
Route::post('/resultado_simulador', 'HomeController@simuladorChart')->name('simulador_results');

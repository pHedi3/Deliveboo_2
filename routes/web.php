<?php

use App\Http\Controllers\RestaurantController;
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

Route::get('/', function () {
    return view('/app.homepage');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/app', function () {
    return view('app.exampleform');
});





Route::get('/dashboard', function () {
    return view('app.dashboard');
})->middleware('auth');;

Route::get('/menù/{id}', 'MenùController@show')->middleware('auth');;

Route::get('/orders/{id}', 'OrderController@show')->middleware('auth');;

Route::get('/stats/{id}', 'StatsController@show')->middleware('auth');;

Route::get('/restaurant/{id}', 'RestaurantController@show');

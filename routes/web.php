<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Models\Clientes;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientesController;

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
})->middleware('auth');

Route::get('home', function () {
    return view('home');



Route::apiResource('clientes', ClientesController::class);
Route::get('clientes/{id}/destroy', 'ClientesController@destroy');
Route::get('clientes/{id}/edit', 'ClientesController@edit');
Route::get('clientes/{id}/update', 'ClientesController@update');
Route::get('clientes/{id}/show', 'ClientesController@show');
Route::get('clientes/{id}/create', 'ClientesController@create');
Route::get('clientes/{id}/store', 'ClientesController@store');
Route::get('clientes/{id}/index', 'ClientesController@index');






});
Auth::routes();
/*
Route::resource('clientes', ClienteController::class);
    return view('clientes');

Auth::routes();

Route::apiResources([
    'clientes'=>Clientes::class,
    
]);

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

*/



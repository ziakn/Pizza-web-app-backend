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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/logoutuser', 'UserController@logout');

Auth::routes();

Route::prefix('/app')->group(function () {
    Route::resource('/dashboardoverview', 'Dashboard\DashboardController');
    Route::resource('/cuisine', 'Dashboard\CuisineController');  
    Route::resource('/ingredient', 'Dashboard\IngredientController');   
    Route::resource('/category', 'Dashboard\CategoryController');
    Route::resource('/pizza', 'Dashboard\PizzaController');
    Route::resource('/order', 'Dashboard\OrderController');
});


//setting
Route::post('/app/updateUser','UserController@updateUser');
Route::get('/app/profile', 'UserController@profile');
Route::post('/app/changepassword', 'UserController@changePass');
Route::post('/app/updatepassword', 'UserController@updatepassword');
Route::post('/app/avatar','UserController@avatar');



Route::any('/{slug}/{child}', [
    'uses' => 'HomeController@dashboard',
 ])->middleware('verified');
 Route::any('/{slug}/{child}/{sub}', [
    'uses' => 'HomeController@dashboard',
 ])->middleware('verified');
 Route::any('/{slug}/{child}/{sub}/{id}', [
    'uses' => 'HomeController@dashboard',
 ])->middleware('verified');

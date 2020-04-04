<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('test', 'TestController@message');
Route::get('user', 'AuthController@user')->middleware('auth:api');
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('forgot', 'PasswordController@forgot_password');
Route::post('reset', 'PasswordController@reset_password');
// Products
Route::get('products', 'ProductsController@index')->middleware('auth:api');
Route::post('products/create', 'ProductsController@create')->middleware('auth:api');
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

Route::get('/','BookController@index');

Route::match(['get','post'],'/register','BookController@register');

Route::match(['get','post'],'/login','BookController@login');

Route::post('/payment','BookController@payment');

Route::get('/logout','BookController@logout');
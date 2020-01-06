<?php

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



Route::get("/chats","ChatController@index");

Route::get("/chats/send","ChatController@send");

Route::get('red/add', 'UserController@addRedUser');//添加红包商户

Route::get('red/add', 'UserController@addRedUser');



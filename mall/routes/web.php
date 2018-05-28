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

Route::get('/', function () {
    return view('welcome');
});

//商品分类模块
Route::get('/category', '\Bedrock\Http\Controllers\Web\CategoryController@index');

//分类添加页面
Route::get('/category/create', '\Bedrock\Http\Controllers\Web\CategoryController@create');

//分类添加操作
Route::post('/category', '\Bedrock\Http\Controllers\Web\CategoryController@store');

//删除分类
Route::get('/category/{category}/delete', '\Bedrock\Http\Controllers\Web\CategoryController@delete');

//编辑分类
Route::get('/category/{category}/edit', '\Bedrock\Http\Controllers\Web\CategoryController@edit');

//编辑分类操作
Route::put('/category/{category}', '\Bedrock\Http\Controllers\Web\CategoryController@update');

//分类显示/隐藏
Route::post('/category/{category}/ishome', '\Bedrock\Http\Controllers\Web\CategoryController@ishome');


//订单概述页面
Route::get('/order', '\Bedrock\Http\Controllers\Web\OrderController@index');

//全部订单
Route::get('/order/list', '\Bedrock\Http\Controllers\Web\OrderController@list');
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

Route::group(['prefix'=>'admin'], function(){
    //登录页面
    Route::get('/login', '\App\Admin\Controllers\LoginController@index');
    //登录行为
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    //注销
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');
    Route::group(['middleware' => 'auth:admin'],function(){
        //首页
        Route::get('/home', '\App\Admin\Controllers\HomeController@index');

       /* Route::group(['middleware'=>'can:system'], function(){
            //用户管理列表
            Route::get('/users', '\App\Admin\Controllers\UserController@index');
            Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
            Route::Post('/users/store', '\App\Admin\Controllers\UserController@store');
            Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role');
            Route::Post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole');

            //角色
            Route::get('/roles', '\App\Admin\Controllers\RoleController@index');
            Route::get('/roles/create', '\App\Admin\Controllers\RoleController@create');
            Route::Post('/roles/store', '\App\Admin\Controllers\RoleController@store');
            Route::get('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission');
            Route::Post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission');

            //权限模块
            Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index');
            Route::get('/permissions/create', '\App\Admin\Controllers\PermissionController@create');
            Route::Post('/permissions/store', '\App\Admin\Controllers\PermissionController@store');*/
        });

    //商品分类模块
    Route::get('/category', '\App\Admin\Controllers\CategoryController@index');

    //分类添加页面
    Route::get('/category/create', '\App\Admin\Controllers\CategoryController@create');

    //分类添加操作
    Route::post('/category', '\App\Admin\Controllers\CategoryController@store');

    //删除分类
    Route::get('/category/{category}/delete', '\App\Admin\Controllers\CategoryController@delete');

    //编辑分类
    Route::get('/category/{category}/edit', '\App\Admin\Controllers\CategoryController@edit');

    //编辑分类操作
    Route::put('/category/{category}', '\App\Admin\Controllers\CategoryController@update');

    //分类显示/隐藏
    Route::post('/category/{category}/ishome', '\App\Admin\Controllers\CategoryController@ishome');

    //文件上传
    Route::get('/file', '\App\Admin\Controllers\CategoryController@delete');

});











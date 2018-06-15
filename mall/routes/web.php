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
    return '欢迎光临磐荣商城！';
});

Route::group(['namespace' => 'Web'],function () {
    Route::get('/web', 'IndexController@getIndex');

    //商品分类模块
    Route::get('/web/category', 'CategoryController@index');

    //分类添加页面
    Route::get('/web/category/create', 'CategoryController@create');

    //分类添加操作
    Route::post('/web/category', 'CategoryController@store');

    //删除分类
    Route::get('/web/category/{category}/delete', 'CategoryController@delete');

    //编辑分类
    Route::get('/web/category/{category}/edit', 'CategoryController@edit');

    //编辑分类操作
    Route::put('/web/category/{category}', 'CategoryController@update');

    //分类显示/隐藏
    Route::post('/web/category/{category}/ishome', 'CategoryController@ishome');

    //商品模块
    Route::get('/web/good', 'GoodController@index');

    //地址联动
    Route::post('/web/good/chooseAddress', 'GoodController@chooseAddress');

    //商品上下架
    Route::post('/web/good/status', 'GoodController@changeStatus');

    //商品审核
    Route::post('/web/good/checked', 'GoodController@checked');

    //商品删除
    Route::post('/web/good/delete', 'GoodController@delete');

    //商品彻底删除
    Route::post('/web/good/physicsDelete', 'GoodController@physicsDelete');

    //编辑商品
    Route::get('/web/good/create', 'GoodController@create');

    //编辑商品
    Route::get('/web/good/{good}/edit', 'GoodController@edit');

    //商品模块新增参数
    Route::get('/web/good/addParams', 'GoodController@addParams');

    //商品模块新增/修改操作
    Route::post('/web/good', 'GoodController@store');

    //会员概述
    Route::get('/web/member', 'MemberController@index');

    //会员概述页信息
    Route::get('/web/member/getMemberInfos', 'MemberController@getMemberInfos');

    //会员列表
    Route::get('/web/member/getList', 'MemberController@getList');

});
//图片上传
Route::post('/uploadImage', 'UploadController@upload');



/*//订单概述页面
Route::get('/order', 'OrderController@index');*/
/*************订单视图页面****************/
//订单概述页面
Route::get('/order', '\Bedrock\Http\Controllers\Web\OrderController@index');
//待发货订单页面
Route::get('/order/status1', '\Bedrock\Http\Controllers\Web\OrderController@status1');
//待收货订单页面
Route::get('/order/status2', '\Bedrock\Http\Controllers\Web\OrderController@status2');
//待付款订单页面
Route::get('/order/status0', '\Bedrock\Http\Controllers\Web\OrderController@status0');
//已完成订单页面
Route::get('/order/orderfinish', '\Bedrock\Http\Controllers\Web\OrderController@orderfinish');
//已关闭订单页面
Route::get('/order/orderlose', '\Bedrock\Http\Controllers\Web\OrderController@orderlose');
//全部订单页面
Route::get('/order/orderlist', '\Bedrock\Http\Controllers\Web\OrderController@orderlist');
//维权申请订单页面
Route::get('/order/status4', '\Bedrock\Http\Controllers\Web\OrderController@status4');
//维权完成订单页面
Route::get('/order/status5', '\Bedrock\Http\Controllers\Web\OrderController@status5');
//自定义导出页面
Route::get('/order/customexport', '\Bedrock\Http\Controllers\Web\OrderController@customexport');
//批量发货页面
Route::get('/order/batchsend', '\Bedrock\Http\Controllers\Web\OrderController@batchsend');

//订单详情页面
Route::get('/order/orderdetail', '\Bedrock\Http\Controllers\Web\OrderController@orderdetail');

/**********************获取数据接口*********************/
Route::get('/order/ajaxgettotals', '\Bedrock\Http\Controllers\Web\OrderController@ajaxgettotals');

Route::get('/order/ajaxorder', '\Bedrock\Http\Controllers\Web\OrderController@ajaxorder');

Route::get('/order/ajaxtransaction', '\Bedrock\Http\Controllers\Web\OrderController@ajaxtransaction');

/***供应商模块***/

Route::group(['namespace' => 'web', 'prefix' => 'web/merch_user'],function () {
    Route::get('/', 'MerchUserController@getIndex');
    Route::get('/add', 'MerchUserController@getCreate');
    Route::post('/add', 'MerchUserController@postCreate');
    Route::get('/{id}/edit', 'MerchUserController@getEdit');
    Route::post('/{id}/edit', 'MerchUserController@postEdit');
    Route::post('/{id}/delete', 'MerchUserController@postDelete');
});

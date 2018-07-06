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
    Route::post('/web/category/{category}/delete', 'CategoryController@delete');

    //编辑分类
    Route::get('/web/category/{category}/edit', 'CategoryController@edit');

    //编辑分类操作
    Route::put('/web/category/', 'CategoryController@update');

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

    //会员黑白名单操作
    Route::post('/web/member/changeBlack', 'MemberController@changeBlack');

    //会员删除
    Route::post('/web/member/delete', 'MemberController@delete');

    //会员详情
    Route::get('/web/member/{member}', 'MemberController@detail');

    //彩虹卡活动列表
    Route::get('/web/rainbowCard/getActivityList', 'RainbowCardController@getActivityList');

    Route::post('/web/rainbowCard/changeIsdisable', 'RainbowCardController@changeIsdisable');

    //活动新增
    Route::get('/web/rainbowCard/create', 'RainbowCardController@create');

    //活动存储
    Route::post('/web/rainbowCard/activityStore', 'RainbowCardController@activityStore');

    //活动修改
    Route::get('/web/rainbowCard/activity/{activity}', 'RainbowCardController@create');

    //彩虹卡列表
    Route::get('/web/rainbowCard/getCardList', 'RainbowCardController@getCardList');

    //彩虹卡号的开启与关闭

    Route::post('/web/rainbowCard/changeDidable', 'RainbowCardController@changeDidable');




});
//图片上传
Route::post('/uploadImage', '\Bedrock\Http\Controllers\Web\UploadController@upload');

/**********************订单概述*********************/
Route::get('/order/ajaxgettotals', '\Bedrock\Http\Controllers\Web\Order\SummaryController@ajaxgettotals');

Route::get('/order/ajaxorder', '\Bedrock\Http\Controllers\Web\Order\SummaryController@ajaxorder');


Route::get('/order/ajaxtransaction', '\Bedrock\Http\Controllers\Web\Order\SummaryController@ajaxtransaction');
//订单概述页面
Route::get('/order/summary', '\Bedrock\Http\Controllers\Web\Order\SummaryController@index');


/*//订单概述页面
Route::get('/order', 'OrderController@index');*/
/*************订单视图页面****************/
//全部订单页面
Route::get('/order/list', '\Bedrock\Http\Controllers\Web\Order\ListController@index');
//待发货订单页面
Route::get('/order/staydelivery', '\Bedrock\Http\Controllers\Web\Order\ListController@staydelivery');
//待收货订单页面
Route::get('/order/staytakedelivery', '\Bedrock\Http\Controllers\Web\Order\ListController@staytakedelivery');
//待付款订单页面
Route::get('/order/staypayment', '\Bedrock\Http\Controllers\Web\Order\ListController@staypayment');
//已完成订单页面
Route::get('/order/orderfinish', '\Bedrock\Http\Controllers\Web\Order\ListController@orderfinish');
//已关闭订单页面
Route::get('/order/orderlose', '\Bedrock\Http\Controllers\Web\Order\ListController@orderclose');


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



/***供应商模块***/

Route::group(['namespace' => 'Web', 'prefix' => 'web/merch_user'],function () {
    Route::get('/', 'MerchUserController@getIndex')->name('webMerchUserIndex');
    Route::get('/add', 'MerchUserController@getCreate')->name('webMerchUserGetCreate');
    Route::post('/add', 'MerchUserController@postCreate')->name('webMerchUserPostCreate');
    Route::get('/{id}/edit', 'MerchUserController@getEdit')->name('webMerchUserGetEdit');
    Route::post('/{id}/edit', 'MerchUserController@postEdit')->name('webMerchUserPostEdit');
    Route::post('/{id}/delete', 'MerchUserController@postDelete')->name('webMerchUserDelete');
});

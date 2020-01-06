<?php

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


Route::namespace('ApiAuth')->group(function(){

    Route::post('password/verification', 'ResetPasswordController@sendResetCode');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::post('register', 'RegisterController@register')->name("register");
    Route::post('register/verification', 'RegisterController@verification');
    Route::post('login', 'LoginController@login')->name("login");
    Route::post('logout', 'LoginController@logout')->middleware('auth:api')->name("logout");

 });

// Authorization  Bearer FNQOhA5SSsMtcQbcymqmAVYowQABXFRu5EiPkWTm8ixThphlR6ofAkIfu5R1tH3o
//TUID 5

Route::middleware('auth:api')->group(function () {
    Route::post('user/password/reset', 'UserController@resetPass');//修改密码
    Route::post('user/name/reset', 'UserController@resetName');//修改用户名
    Route::post('user/set/pic', 'UserController@setPic');//上传头像
    Route::get('shara/code', 'UserController@checkUserShara');//判断邀请码是否有效
    Route::get('first/send', 'UserController@firstRegister');//用户注册通知群接口
    

    Route::get('pay/list/all', 'PayController@getPayList');//获取支持支付方式
    Route::post('pay/create', 'PayController@store')->middleware('checkPassword','checkRealName');//新增支付方式
    Route::get('pay', 'PayController@index');//获取用户支付方式
    Route::get('pay/show', 'PayController@show');//获取支付详情
    Route::post('pay/destroy', 'PayController@destroy')->middleware('checkPassword');//删除指定支付方式

    Route::get('info/pass/exits', 'UserInfoController@passwordExist');//获取用户是否设置交易密码
    Route::post('info/pass', 'UserInfoController@setPassWord')->middleware('checkCode');//设置交易密码
    Route::post('info/pass/verification', 'UserInfoController@verificationPassword');//验证密码是否正确
    Route::post('info/pass/reset', 'UserInfoController@resetJyPassword')->middleware('checkCode');//修改交易密码
    Route::get('info/real/name', 'UserInfoController@isReadName');//判断是否实名制
    Route::post('info/set/name', 'UserInfoController@addReal')->middleware('checkPassword');//实名认证
    Route::get('info/grade', 'UserInfoController@getUserInfo');//获取当前用户的积分、等级
    Route::get('info/user/rate', 'UserInfoController@getUserRate');//获取当前用户的积分、等级



    Route::get('user/rate', 'UserInfoController@showRate');//获取当前用户的下级费率
    Route::post('user/rate/set', 'UserInfoController@setRate')->middleware('checkPassword');//设置费率




    Route::get('send/code', 'IndexController@send');//当前用户发送短信
    Route::post('pay/code', 'IndexController@upcode');//上传支付收款码


    Route::post('transaction/create', 'TransactionController@store')->middleware('checkIdentity','checkPassword', 'checkRealName');//新增挂单
    Route::get('transaction', 'TransactionController@index');//挂单列表
    Route::post('transaction/cancel', 'TransactionController@destroy')->middleware('checkPassword','checkRealName');//取消挂单

    Route::post('transaction/order', 'TransactionOrderController@store')->middleware('checkPassword','checkRealName');//新增购买
    Route::get('transaction/order/show', 'TransactionOrderController@show');//获取指定订单详情
    Route::post('transaction/order/payment', 'TransactionOrderController@payMent');//用户已付款
    Route::post('transaction/order/paycancel', 'TransactionOrderController@payCancel');//用户取消
    Route::post('transaction/order/nomoney', 'TransactionOrderController@payNocollectMoney')->middleware('checkIdentity','checkPassword');//管理员未收到钱
    Route::post('transaction/order/pay/currency', 'TransactionOrderController@payCollectMoney')->middleware('checkIdentity','checkPassword');
    Route::get('transaction/order/list', 'TransactionOrderController@getOrderList');//获取订单记录
    Route::get('transaction/order/send/notice', 'TransactionOrderController@setNoticePayCurrency');//提醒用户尽快发货 ->middleware('throttle:1,10')



    Route::post('complaint/pic', 'ComplaintController@addPic');//上传投诉图片
    Route::post('complaint', 'ComplaintController@store');//新增投诉

    Route::post('group/name', 'GroupchatController@setGroupName')->middleware('checkIdentity');//修改战队名称
    Route::get('group/info', 'GroupchatController@getInfo');//获取战队信息
    Route::get('group/day/info', 'GroupchatController@getDayOrderBy');//获取战队今日排行
    Route::get('group/all/info', 'GroupchatController@getAllOrderBy');//获取战队历史排行信息
    Route::get('group/user', 'GroupchatController@getUser');//获取战队成员



    Route::post('group/nocite/crate', 'GroupNociteController@store')->middleware('checkIdentity');//发布公告
    Route::get('group/nocite', 'GroupNociteController@index');//获取公告列表
    Route::get('group/nocite/show', 'GroupNociteController@show');//获取指定详情
    Route::post('group/nocite/destroy', 'GroupNociteController@destroy')->middleware('checkIdentity');//删除指定公告
    Route::post('group/nocite/update', 'GroupNociteController@update')->middleware('checkIdentity');//删除指定公告


    Route::post("talk/bind","TalkController@bind");//绑定
    Route::post("talk/send","TalkController@send");//发送
    Route::post('talk/no', 'TalkController@addNoTalk')->middleware('checkIdentity');//新增用户禁言
    Route::post('talk/yes', 'TalkController@addYesTalk')->middleware('checkIdentity');//解除用户禁言

    Route::post('task/receipt', 'TaskController@userTaskGenerate');//新增用户枪红包
    Route::get('task/show', 'TaskController@getDatil');//获取订单详情
    Route::post('task/pay/currency', 'TaskController@userPayCurrency')->middleware('checkPassword');//卖家确定收款-支付
    Route::get('task/index', 'TaskController@getTaskIndex');//获取当前用户的任务记录
    Route::get('task/group/index', 'TaskController@getGroupIndex');//获取当前群的任务记录

    Route::get('account/show', 'AccountController@show');//获取当前用户的账户信息
    Route::get('account/index', 'AccountController@index');//查询当前用户的交易记录


    Route::get('notice/total', 'NoticeDataController@listTotal');//获取未读通知数量
    Route::get('notice/type/list', 'NoticeDataController@getTypeList');//获取类型列表
    Route::get('notice/show', 'NoticeDataController@show');//获取类型列表
    Route::post('notice/del', 'NoticeDataController@del');//获取类型列表

    //获取红包状态---聊天页面使用
    Route::post('task/state', 'TaskController@judgeState');//获取红包状态---聊天页面使用

    //获取用户是否在线
    Route::post('user/isonline', 'TalkController@isOnline');//获取红包状态---聊天页面使用


});
//->middleware(['checkCode'])验证验证码是否正确  checkPassword 验证交易密码

Route::post('verification/code', 'IndexController@mobileCode');//验证手机号是否正确
Route::get('shara/code/use', 'UserController@checkUserSharaIsUse');//判断邀请码是否有效

Route::get('static/service', 'StaticController@getServiceProtocol');//获取服务协议
Route::get('static/ys', 'StaticController@getYs');//获取隐私政策
Route::get('static/jbxz', 'StaticController@getJbxz');//获取举报须知



Route::post("task/add","TaskController@addTask");//新增红任务
Route::post('task/status', 'TaskController@getStauts');//商户获取用户状态
Route::post('task/pay/money', 'TaskController@setPayMoney');//商户付款
Route::post('task/cancel', 'TaskController@setCancel');//商户主动取消订单
Route::post('task/complaint', 'TaskController@setComplaints');//商户订单异常申请api


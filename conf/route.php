<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//>php think build --module admin   ()
//>php	think	make:controller	common/WapBase  (模块/控制器)
//>php	think	make:model	index/Blog   (模块/模型)

//动态注册方式
//use	think\Route;
//	注册路由到index模块的News控制器的read操作
//Route::get('new/:id','News/read');	//	定义GET请求路由规则

//定义路由配置文件,直接return返回
return [
    //路由组
//    '[mobile]'					=>	[
//        ':id'			=>	['Blog/read',	['method'	=>	'get'],	['id'	=>	'\d+']],
//        ':name'	=>	['Blog/read',	['method'	=>	'post']],
//    ],

    '/show/[:type]'            => 'mobile/Index/index',      //首页
    'entry/index'            => 'mobile/OpenEntry/index',   //qq,alipay 网页授权界面


    //商品搜索
    'goods/list/[:cat_id]'            => 'mobile/Goods/goodList',
    'goods/get_list'            => ['mobile/Goods/ajaxGoodList',['method'=>'post'],['ajax'=>true]],     //ajax获取列表
    'goods/info/[:goods_id]'            => 'mobile/Goods/goodsInfo',
    'goods/category'            => 'mobile/Goods/category',


    //购物车
    'cart$'            => 'mobile/Cart/cart',   //购物车
    'cart/add'   => ['mobile/Cart/ajaxAdd',['method'=>'post'],['ajax'=>true]],
    'cart/update'   => ['mobile/Cart/ajaxUpdate',['method'=>'post'],['ajax'=>true]],
    'cart/num'   => ['mobile/Cart/ajaxNum',['method'=>'post'],['ajax'=>true]],
    'cart/delete'   => ['mobile/Cart/ajaxDel',['method'=>'post'],['ajax'=>true]],
    'cart/analyse/:from'   => ['mobile/Cart/analyse',['method'=>'get']],
    'cart/pay_show'   => 'mobile/Cart/payShow',

    'oauth/:entry_way'  =>  'mobile/Login/oauth',   //授权
    'login/:entry_way'  =>  'mobile/Login/login',   //第三方授权登录回调



    //个人中心
    'user$'            => 'mobile/User/userCenter',     //$完全匹配
    'user/address'            => 'mobile/User/addressList',     //地址列表
    'user/add_address/[:id]'            => 'mobile/User/addAddress',    //展示页
    'user/save_address'            => 'mobile/User/saveAddress',    //新增、更新

    //订单
    'order/unpaid'            => 'mobile/Order/unpaid',
    'order/unfilled'            => 'mobile/Order/unfilled',
    'order/remark'            => 'mobile/Order/remark',
    'order/refund'            => 'mobile/Order/refund',
    'order/show_way'            => 'mobile/Order/showPay',      //展示支付

    //用户订单假删除
    'order/del'            => ['mobile/Order/del',['method'=>'get'],'ajax'=>true],

    //支付
    'payment/pay'   => 'mobile/Payment/pay',        //提交订单支付
    'payment/notify_url/:pay_code'   => 'mobile/Payment/notifyUrl',        //
    'payment/return_url/:pay_code'   => 'mobile/Payment/returnUrl',        //


    //售后
    'service'            => 'mobile/SalesService/service',


    'api/region'    => ['mobile/Api/region',['method'=>'get'],['ajax'=>true]],






];


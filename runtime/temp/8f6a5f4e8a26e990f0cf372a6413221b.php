<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"E:\shopweb\pay.mz211.com/application/mobile\view\user\userCenter.html";i:1533375177;s:68:"E:\shopweb\pay.mz211.com/application/mobile\view\common\_header.html";i:1533372786;s:68:"E:\shopweb\pay.mz211.com/application/mobile\view\common\_footer.html";i:1533372820;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/static/mobile/css/style.css">
    <script type="text/javascript" src="/static/mobile/js/jquery.js"></script>
    <script type="text/javascript" src="/static/mobile/js/common.js"></script>
</head>
<body class="font">
<!-- 头部 -->
<div id="top" class="white pos_rel"><h2 class="txt_c f36 white_gray">个人中心</h2><span class="top_back pos_abs f32"><a class="go_back white">返回</a><a class="close ml10 white">关闭</a></span><a class="top_set pos_abs" href="<?php echo url('mobile/Goods/category'); ?>"></a></div>
<div class="bgc_blue txt_c box_person">
	<div class="personal"><img src="/static/mobile/images/icon_person.png" alt="个人中心" title="个人中心"></div>
	<div class="personal_txt mt16"><a href="#" class="white"><?php echo $user['nickname']; ?></a></div>
</div>
<!-- 我的订单 -->
<div class="border_topBot bgc_white"><a href="#" class="myOrder black">我的订单</a></div>
<!-- 导航 -->
<ul class="box_shadow_bot2 mt16 clearfix fast_nav txt_c bgc_white">
	<li><a href="<?php echo url('mobile/Order/unpaid'); ?>"><img src="/static/mobile/images/img_unpaid.png" alt="待支付"></a></li>
	<li><a href="<?php echo url('mobile/Order/unfilled'); ?>"><img src="/static/mobile/images/img_inbound.png" alt="待收货"></a></li>
	<li><a href="<?php echo url('mobile/Order/remark'); ?>"><img src="/static/mobile/images/img_evaluated.png" alt="待评价"></a></li>
	<li><a href="<?php echo url('mobile/Order/refund'); ?>"><img src="/static/mobile/images/img_returning.png" alt="退货中"></a></li>
</ul>
<ul class="fast_nav2 bor_top_gray mt16 bgc_white">
	<li><a href="<?php echo url('mobile/Cart/cart'); ?>" class="fn_carts">购物车</a></li>
	<li><a href="#" class="fn_collect">收藏</a></li>
	<li><a href="<?php echo url('mobile/User/addressList'); ?>" class="fn_address">收货地址管理</a></li>
	<li><a href="#" class="fn_infos">消息中心</a></li>
	<li><a href="#" class="fn_help">帮助中心</a></li>
    <li><a href="#" class="fn_help">每日签到</a></li>
</ul>
<div class="m100"></div>
<ul id="bot_nav" class="clearfix">
    <li class="cur"><a href="<?php echo url('mobile/Index/index'); ?>"><img src="/static/mobile/images/img_shopping.png" alt="首页"><!-- 购物 --></a></li>
    <li><a href="<?php echo url('mobile/Goods/goodList'); ?>"><img src="/static/mobile/images/img_search.png" alt="搜索"><!-- 搜索 --></a></li>
    <li><a href="<?php echo url('mobile/User/userCenter'); ?>"><img src="/static/mobile/images/img_person.png" alt="个人中心"><!-- 个人中心 --></a></li>
    <li><a href="<?php echo url('mobile/Cart/cart'); ?>"><img src="/static/mobile/images/img_cart.png" alt="购物车"><!-- 购物车 --></a></li>
    <li><a href="<?php echo url('mobile/SalesService/service'); ?>"><img src="/static/mobile/images/img_selled.png" alt="售后"><!-- 售后 --></a></li>
</ul>
<script>
    //返回
    $(".go_back").live('click',function () {
        window.history.go(-1);
    });

    //刷新
    function refresh() {
        location.replace(location.href);
    }
</script>
</body>
</html>
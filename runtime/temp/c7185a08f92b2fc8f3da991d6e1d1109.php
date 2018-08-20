<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"E:\shopweb\pay.mz211.com/application/mobile\view\index\index.html";i:1533372845;s:68:"E:\shopweb\pay.mz211.com/application/mobile\view\common\_header.html";i:1533372786;s:68:"E:\shopweb\pay.mz211.com/application/mobile\view\common\_footer.html";i:1533372820;}*/ ?>
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
<body class="font" id="body">
<div id="head" class="pos_rel">
    <!-- 头部 -->
    <div id="top" class="white pos_rel"><h2 class="txt_c f36 white_gray">微商城</h2><span class="top_back pos_abs f32"><a class="go_back white">返回</a></span><a class="top_set pos_abs" href="<?php echo url('mobile/Goods/category'); ?>"></a></div>
    <!-- 搜索栏 -->
    <div id="search_1" class="pos_rel">
        <form method="post" action="<?php echo url('mobile/Goods/goodList'); ?>" onsubmit="return checkData();">
        <!--<a href="#" class="menu pos_abs" id="menuBtn"></a>-->
        <a href="<?php echo url('mobile/Goods/category'); ?>" class="menu pos_abs" id="category"></a>
        <div class="search ml70">
            <span class="txt"><input name="keyword" type="text" value="请输入搜索内容" id="input_txt" class="f20" onclick="this.value=''"></span>
            <input type="submit" id="input_btn" value="搜索" class="pos_abs f32">
        </div>
        </form>
    </div>
</div>
<!-- 频道导航 -->
<div id="menu_nav" class="bgc_white txt_c">
    <ul>
        <?php if(is_array($goodsCategory) || $goodsCategory instanceof \think\Collection || $goodsCategory instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <li><a href="<?php echo url('mobile/Goods/goodList',['cat'=>$vo['id']]); ?>">{$vo.name}</a></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
<!-- 广告位 -->
<div class="ad"><img src="/static/mobile/images/banner/banner.jpg" alt="广告位" title="广告位" class="full_img"></div>
<!-- 导航 -->
<ul id="nav" class="txt_c f32 mb30 clearfix">
    <li <?php if($type == ''): ?> class="cur" <?php endif; ?>><a href="/">推荐</a></li>
    <li <?php if($type == 'sales'): ?> class="cur" <?php endif; ?>><a href="<?php echo url('/show/sales'); ?>">销量</a></li>
    <li <?php if($type == 'click'): ?> class="cur" <?php endif; ?>><a href="<?php echo url('/show/click'); ?>">人气</a></li>
    <li <?php if($type == 'new'): ?> class="cur" <?php endif; ?>><a href="<?php echo url('/show/new'); ?>" class="no_backg">新品</a></li>
</ul>
<!-- 产品 -->
<?php if(is_array($goodsList) || $goodsList instanceof \think\Collection || $goodsList instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
<div class="products">
    <a href="<?php echo url('mobile/Goods/goodsInfo',['goods_id'=>$vo['goods_id']]); ?>"><div class="pro_img"><img src="/static/mobile/images/none/pro_default.jpg" alt="产品图" title="产品图" class="full_img"></div></a>
    <div class="pro_info">
        <h3><a href="<?php echo url('mobile/Goods/goodsInfo',['goods_id'=>$vo['goods_id']]); ?>"><?php echo $vo['goods_name']; ?></a></h3>
        <h4><a href="<?php echo url('mobile/Goods/goodsInfo',['goods_id'=>$vo['goods_id']]); ?>"><?php echo $vo['goods_remark']; ?></a></h4>
        <div><span class="price">￥<?php echo $vo['shop_price']; ?></span><a href="#" class="more iconfont">&#xe621;</a></div>
    </div>
</div>
<?php endforeach; endif; else: echo "" ;endif; ?>

<script>
    //导航
//    fnNav("menuBtn","menu_nav",'head');
    function checkData(){
        input_text = document.getElementById("input_txt").value;
        return (input_text != "" && input_text != '请输入搜索内容');
    }
</script>
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
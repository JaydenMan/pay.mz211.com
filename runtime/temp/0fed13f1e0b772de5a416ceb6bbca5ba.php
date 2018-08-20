<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:68:"E:\shopweb\pay.mz211.com/application/admin\view\goods\goodsList.html";i:1534562786;s:66:"E:\shopweb\pay.mz211.com/application/admin\view\public\_blank.html";i:1533439759;s:65:"E:\shopweb\pay.mz211.com/application/admin\view\public\_meta.html";i:1533700585;s:67:"E:\shopweb\pay.mz211.com/application/admin\view\public\_footer.html";i:1534232388;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title>商城后台</title>
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/static/plugins/hui/h-ui/lib/html5shiv.js"></script>
<script type="text/javascript" src="/static/plugins/hui/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/plugins/hui/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/plugins/hui/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/static/plugins/hui/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/plugins/hui/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/plugins/hui/h-ui.admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/css/common.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/static/plugins/hui/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--  以下为框架script  -->
<script type="text/javascript" src="/static/plugins/hui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/plugins/hui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/plugins/hui/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/plugins/hui/h-ui.admin/js/H-ui.admin.js"></script>
<!--  以下为常用但非框架script (日期、表格控件)  -->
<script type="text/javascript" src="/static/plugins/hui/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript" src="/static/plugins/hui/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/static/plugins/hui/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/static/plugins/hui/lib/laypage/1.2/laypage.js"></script>


</head>
<body>

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商品管理 <span class="c-gray en">&gt;</span> 商品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="#" method="get">
        <div class="text-c">
            <!--支付时间：<input type="text" name="start_time" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="datemin" class="input-text Wdate" style="width:160px;" autocomplete="off">-<input type="text" name="end_time" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="datemax" class="input-text Wdate" style="width:160px;" autocomplete="off">-->
            <span class="select-box inline"><select class="select" name="cat_id">
                <option value="">分类</option>
                <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['id']; ?>" <?php if(\think\Request::instance()->get('cat_id') == $vo['id']): ?>selected<?php endif; ?> ><?php echo $vo['char_name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select></span> &nbsp;&nbsp;&nbsp;
            <span class="select-box inline"><select class="select" name="is_on_sale"><option value="">上架状态</option><option value="1" <?php if(\think\Request::instance()->get('is_on_sale') == '1'): ?>selected<?php endif; ?>>是</option><option value="0" <?php if(\think\Request::instance()->get('is_on_sale') == '0'): ?>selected<?php endif; ?>>否</option></select></span>&nbsp;&nbsp;&nbsp;
            <span class="select-box inline"><select class="select" name="other"><option value="">其它</option><option value="1" <?php if(\think\Request::instance()->get('other') == '1'): ?>selected<?php endif; ?>>热卖</option><option value="2" <?php if(\think\Request::instance()->get('other') == '2'): ?>selected<?php endif; ?>>推荐</option><option value="3" <?php if(\think\Request::instance()->get('other') == '3'): ?>selected<?php endif; ?>>新品</option></select></span>&nbsp;&nbsp;&nbsp;
            <input type="text" class="input-text" style="width:250px" placeholder="商品名称" id="" name="goods_name" value="<?php echo \think\Request::instance()->get('goods_name'); ?>">
            <input type="submit" class="btn btn-success" value="查询">
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <!--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>-->
            <a class="btn btn-primary radius" onclick="goodsAdd('添加商品','<?php echo url("admin/Goods/goodsAdd"); ?>')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加商品</a>
        </span>
        <!--<span class="r">共有数据：<strong>54</strong> 条</span>-->
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-responsive">
            <thead>
                <tr>
                    <th scope="col" colspan="12">商品列表</th>
                </tr>
                <tr class="text-c">
                    <th width="40"><input name="" type="checkbox" value=""></th>
                    <th width="40">id</th>
                    <th width="60">缩略图</th>
                    <th width="150">商品名称</th>
                    <th width="60">分类</th>
                    <th width="60">价格</th>
                    <th width="40">热卖</th>
                    <th width="40">推荐</th>
                    <th width="40">新品</th>
                    <th width="40">上架状态</th>
                    <th width="60">库存</th>
                    <th width="100">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($goodsList) || $goodsList instanceof \think\Collection || $goodsList instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr class="text-c">
                    <td><input name="" type="checkbox" value=""></td>
                    <td><?php echo $vo['goods_id']; ?></td>
                    <td><a onClick="product_show('图片','product-show.html','10001')" href="javascript:;"><img width="60" class="product-thumb" src="https://img.alicdn.com/tfs/TB1qpwlQXXXXXcCXXXXXXXXXXXX-256-256.png_60x60.jpg_.webp?<?php echo $vo['original_img']; ?>"></a>
                    </td>
                    <td class="text-l"><a style="text-decoration:none" href="javascript:;"><?php echo $vo['goods_name']; ?></a></td>
                    <td class="text-l"><?php if(!(empty($cateList[$vo['cat_id']]['name']) || (($cateList[$vo['cat_id']]['name'] instanceof \think\Collection || $cateList[$vo['cat_id']]['name'] instanceof \think\Paginator ) && $cateList[$vo['cat_id']]['name']->isEmpty()))): ?><?php echo $cateList[$vo['cat_id']]['name']; endif; ?></td>
                    <td>￥ <span class="price"><?php echo $vo['shop_price']; ?></span></td>
                    <td><a class="badge <?php if($vo['is_hot'] == '1'): ?>badge-success<?php else: ?>label-default<?php endif; ?> radius" href="javascript:;"><?php if($vo['is_hot'] == '1'): ?>是<?php else: ?>否<?php endif; ?></a></td>
                    <td><a class="badge <?php if($vo['is_recommend'] == '1'): ?>badge-success<?php else: ?>label-default<?php endif; ?> radius" href="javascript:;"><?php if($vo['is_recommend'] == '1'): ?>是<?php else: ?>否<?php endif; ?></a></td>
                    <td><a class="badge <?php if($vo['is_new'] == '1'): ?>badge-success<?php else: ?>label-default<?php endif; ?> radius" href="javascript:;"><?php if($vo['is_new'] == '1'): ?>是<?php else: ?>否<?php endif; ?></a></td>
                    <td><a class="badge <?php if($vo['is_on_sale'] == '1'): ?>badge-success<?php else: ?>label-default<?php endif; ?> radius" href="javascript:;"><?php if($vo['is_on_sale'] == '1'): ?>是<?php else: ?>否<?php endif; ?></a></td>
                    <td class="text-l"><?php echo $vo['store_count']; ?></td>
                    <td class="td-manage"><a style="text-decoration:none" onClick="product_stop(this,'10001')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_edit('产品编辑','product-add.html','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_del(this,'10001')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div class="text-c"><?php echo $goodsList->render(); ?></div>
</div>

<script type="text/javascript">
    $(function(){
        $("body").Huitab({
            tabBar:".navbar-wrapper .navbar-levelone",
            tabCon:".Hui-aside .menu_dropdown",
            className:"current",
            index:0
        });
    });
    /*个人信息*/
    function myselfinfo(){
        layer.open({
            type: 1,
            area: ['300px','200px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            title: '查看信息',
            content: '<div>管理员信息</div>'
        });
    }

    //父刷新
    function parentReload() {
        parent.location.replace(parent.location.href);
    }

    //刷新
    function reload() {
        location.replace(location.href);
    }
</script> <!-- 底部script -->

<script type="text/javascript">

    /*产品-添加*/
    function goodsAdd(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*产品-查看*/
    function product_show(title, url, id) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*产品-审核*/
    function product_shenhe(obj, id) {
        layer.confirm('审核文章？', {
                btn: ['通过', '不通过'],
                shade: false
            },
            function () {
                $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                $(obj).remove();
                layer.msg('已发布', {icon: 6, time: 1000});
            },
            function () {
                $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
                $(obj).remove();
                layer.msg('未通过', {icon: 5, time: 1000});
            });
    }
    /*产品-下架*/
    function product_stop(obj, id) {
        layer.confirm('确认要下架吗？', function (index) {
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_start(this,id)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
            $(obj).remove();
            layer.msg('已下架!', {icon: 5, time: 1000});
        });
    }

    /*产品-发布*/
    function product_start(obj, id) {
        layer.confirm('确认要发布吗？', function (index) {
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_stop(this,id)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
            $(obj).remove();
            layer.msg('已发布!', {icon: 6, time: 1000});
        });
    }

    /*产品-申请上线*/
    function product_shenqing(obj, id) {
        $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
        $(obj).parents("tr").find(".td-manage").html("");
        layer.msg('已提交申请，耐心等待审核!', {icon: 1, time: 2000});
    }

    /*产品-编辑*/
    function product_edit(title, url, id) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*产品-删除*/
    function product_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function (data) {
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!', {icon: 1, time: 1000});
                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    }
</script>

</body>
</html>
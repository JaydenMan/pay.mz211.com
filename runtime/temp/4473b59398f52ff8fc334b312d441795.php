<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:68:"E:\shopweb\pay.mz211.com/application/admin\view\order\orderList.html";i:1534216160;s:66:"E:\shopweb\pay.mz211.com/application/admin\view\public\_blank.html";i:1533439759;s:65:"E:\shopweb\pay.mz211.com/application/admin\view\public\_meta.html";i:1533700585;s:67:"E:\shopweb\pay.mz211.com/application/admin\view\public\_footer.html";i:1534232388;}*/ ?>
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

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="#" method="get">
        <div class="text-c">
            支付时间：
            <input type="text" name="start_time" value="<?php echo \think\Request::instance()->param('start_time'); ?>" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="datemin" class="input-text Wdate" style="width:160px;" autocomplete="off">-
            <input type="text" name="end_time" value="<?php echo \think\Request::instance()->param('end_time'); ?>" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm:ss' })" id="datemax" class="input-text Wdate" style="width:160px;" autocomplete="off">
            <span class="select-box inline">
                <select class="select" name="order_status">
                <option value="">订单状态</option>
                <option value="0" <?php if(\think\Request::instance()->get('order_status') == '0'): ?>selected<?php endif; ?> >待确认</option>
                <option value="1" <?php if(\think\Request::instance()->get('order_status') == '1'): ?>selected<?php endif; ?> >已确认</option>
                <option value="2" <?php if(\think\Request::instance()->get('order_status') == '2'): ?>selected<?php endif; ?> >已收货</option>
                <option value="3" <?php if(\think\Request::instance()->get('order_status') == '3'): ?>selected<?php endif; ?> >已取消</option>
                <option value="4" <?php if(\think\Request::instance()->get('order_status') == '4'): ?>selected<?php endif; ?> >已完成评价</option>
                <option value="5" <?php if(\think\Request::instance()->get('order_status') == '5'): ?>selected<?php endif; ?> >已作废</option>
                </select>
            </span>&nbsp;&nbsp;&nbsp;
            <span class="select-box inline"><select class="select" name="shipping_status"><option value="">发货状态</option><option value="0" <?php if(\think\Request::instance()->get('shipping_status') == '0'): ?>selected<?php endif; ?>>未发货</option><option value="1" <?php if(\think\Request::instance()->get('shipping_status') == '1'): ?>selected<?php endif; ?>>已发货</option><option value="2" <?php if(\think\Request::instance()->get('shipping_status') == '2'): ?>selected<?php endif; ?>>部分发货</option></select></span>&nbsp;&nbsp;&nbsp;
            <span class="select-box inline"><select class="select" name="pay_status"><option value="">支付状态</option><option value="1" <?php if(\think\Request::instance()->get('pay_status') == '1'): ?>selected<?php endif; ?>>已支付</option><option value="0" <?php if(\think\Request::instance()->get('pay_status') == '0'): ?>selected<?php endif; ?>>未支付</option></select></span>&nbsp;&nbsp;&nbsp;
            <input type="text" class="input-text" style="width:250px" placeholder="订单号" id="" name="order_sn" value="<?php echo \think\Request::instance()->get('order_sn'); ?>">
            <input type="submit" class="btn btn-success" value="查询">
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <!--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>-->
            <a class="btn btn-primary radius" onclick="product_add('添加产品','product-add.html')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 增加分类</a>
        </span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-responsive">
            <thead>
            <tr class="text-c">
                <th width="160">订单号</th>
                <th width="60">用户id</th>
                <th width="50">订单状态</th>
                <th width="50">支付状态</th>
                <th width="50">发货状态</th>
                <th width="60">支付code</th>
                <th width="60">物流code</th>
                <th width="60">订单总价</th>
                <th width="60">应付款金额</th>
                <th width="60">实际支付金额</th>
                <th width="60">支付时间</th>
                <th width="60">第三方流水号</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($orderList) || $orderList instanceof \think\Collection || $orderList instanceof \think\Paginator): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="text-c">
                <td><?php echo $vo['order_sn']; ?></td>
                <td><?php echo $vo['user_id']; ?></td>
                <td>
                    <span class="badge
                    <?php if($vo['order_status'] == '0'): ?>badge-default radius">待确认<?php endif; if($vo['order_status'] == '1'): ?>badge-warning radius">已确认<?php endif; if($vo['order_status'] == '2'): ?>badge-success radius">已收货<?php endif; if($vo['order_status'] == '3'): ?> radius" style="background-color:#ddd;">已取消<?php endif; if($vo['order_status'] == '4'): ?> radius" style="background-color:#00D300;">已完成评价<?php endif; if($vo['order_status'] == '5'): ?>badge-danger radius">已作废<?php endif; ?>
                    </span>
                </td>
                <td>
                    <span class="badge
                    <?php if($vo['pay_status'] == '0'): ?>badge-default radius">未支付<?php endif; if($vo['pay_status'] == '1'): ?>badge-success radius">已付款<?php endif; ?>
                    </span>
                </td>
                <td>
                    <span class="badge
                    <?php if($vo['shipping_status'] == '0'): ?>badge-default radius">未发货<?php endif; if($vo['shipping_status'] == '1'): ?>badge-success radius">已发货<?php endif; if($vo['shipping_status'] == '2'): ?> radius" style="background-color:#E5FFFF;">部分发货<?php endif; ?>
                    </span>
                </td>
                <td><?php echo $vo['pay_code']; ?></td>
                <td><?php echo $vo['shipping_code']; ?></td>
                <td>￥ <span class="price"><?php echo $vo['total_amount']; ?></span></td>
                <td>￥ <span class="price"><?php echo $vo['order_amount']; ?></span></td>
                <td>￥ <span class="price"><?php echo $vo['real_amount']; ?></span></td>
                <td><?php if(empty($vo['pay_time']) || (($vo['pay_time'] instanceof \think\Collection || $vo['pay_time'] instanceof \think\Paginator ) && $vo['pay_time']->isEmpty())): else: ?><?php echo date("Y-m-d H:i:s",$vo['pay_time']); endif; ?></td>
                <td><?php echo $vo['transaction_id']; ?></td>
                <td class="td-manage"><a style="text-decoration:none" onClick="product_stop(this,'10001')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_edit('产品编辑','product-add.html','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_del(this,'10001')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div class="text-c"><?php echo $orderList->render(); ?></div>
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
    var setting = {
        view: {
            dblClickExpand: false,
            showLine: false,
            selectedMulti: false
        },
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "pId",
                rootPId: ""
            }
        },
        callback: {
            beforeClick: function (treeId, treeNode) {
                var zTree = $.fn.zTree.getZTreeObj("tree");
                if (treeNode.isParent) {
                    zTree.expandNode(treeNode);
                    return false;
                } else {
                    //demoIframe.attr("src",treeNode.file + ".html");
                    return true;
                }
            }
        }
    };

    var zNodes = [
        {id: 1, pId: 0, name: "一级分类", open: true},
        {id: 11, pId: 1, name: "二级分类"},
        {id: 111, pId: 11, name: "三级分类"},
        {id: 112, pId: 11, name: "三级分类"},
        {id: 113, pId: 11, name: "三级分类"},
        {id: 114, pId: 11, name: "三级分类"},
        {id: 115, pId: 11, name: "三级分类"},
        {id: 12, pId: 1, name: "二级分类 1-2"},
        {id: 121, pId: 12, name: "三级分类 1-2-1"},
        {id: 122, pId: 12, name: "三级分类 1-2-2"},
    ];


//    $(document).ready(function () {
//        var t = $("#treeDemo");
//        t = $.fn.zTree.init(t, setting, zNodes);
//        demoIframe = $("#testIframe");
//        demoIframe.on("load", loadReady);
//        var zTree = $.fn.zTree.getZTreeObj("tree");
//        zTree.selectNode(zTree.getNodeByParam("id",'11'));
//    });

    $('.table-sort').dataTable({
        "aaSorting": [[1, "desc"]],//默认第几个排序
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            {"orderable": false, "aTargets": [0, 7]}// 制定列不参与排序
        ]
    });
    /*产品-添加*/
    function product_add(title, url) {
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
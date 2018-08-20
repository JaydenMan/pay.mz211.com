<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"E:\shopweb\pay.mz211.com/application/admin\view\goods\goodsTypeList.html";i:1534235108;s:66:"E:\shopweb\pay.mz211.com/application/admin\view\public\_blank.html";i:1533439759;s:65:"E:\shopweb\pay.mz211.com/application/admin\view\public\_meta.html";i:1533700585;s:67:"E:\shopweb\pay.mz211.com/application/admin\view\public\_footer.html";i:1534232388;}*/ ?>
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
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-primary radius" onclick="addGoodsType('添加模型','<?php echo url("admin/Goods/goodsTypeAdd"); ?>',400,200)" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加模型</a>
        </span>
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
                    <th width="150">名称</th>
                    <th width="100">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr class="text-c">
                    <td><input name="" type="checkbox" value=""></td>
                    <td class="text-l"><a style="text-decoration:none" href="javascript:;"><?php echo $vo['id']; ?></a></td>
                    <td class="text-l"><a style="text-decoration:none" href="javascript:;"><?php echo $vo['name']; ?></a></td>
                    <td class="td-manage"><a style="text-decoration:none" class="ml-5" onClick="addGoodsType('编辑模型','<?php echo url("admin/Goods/goodsTypeAdd",['id'=>$vo['id']]); ?>',400,200);" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_del(this,'<?php echo $vo['id']; ?>')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
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
    /*产品-查看*/
    function addGoodsType(title, url, w,h) {
        layer_show(title,url,w,h);
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

    /*产品-编辑*/
    function product_edit(title, url, id) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    function product_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                type: 'POST',
                data: {id:id},
                url: "<?php echo url('admin/Goods/goodsTypeDel','',''); ?>",
                dataType: 'json',
                success: function (data) {
                    if(data.code == 0){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!', {icon: 1, time: 1000});
                        reload();
                    } else {
                        layer.msg('删除失败!', {icon: 2, time: 1000});
                    }
                },
                error: function (data) {
                    console.log(data.msg);
                }
            });
        });
    }

</script>

</body>
</html>
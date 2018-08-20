<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:71:"E:\shopweb\pay.mz211.com/application/admin\view\goods\goodsTypeAdd.html";i:1534219330;s:66:"E:\shopweb\pay.mz211.com/application/admin\view\public\_blank.html";i:1533439759;s:65:"E:\shopweb\pay.mz211.com/application/admin\view\public\_meta.html";i:1533700585;s:67:"E:\shopweb\pay.mz211.com/application/admin\view\public\_footer.html";i:1534232388;}*/ ?>
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

<article class="page-container">
	<form action="" method="get" class="form form-horizontal" id="form-article-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>模型名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="hidden" value="<?php echo !empty($info['id'])?$info['id'] : ''; ?>" name="id">
				<input type="text" class="input-text" value="<?php echo !empty($info['name'])?$info['name'] : ''; ?>" placeholder="" name="name">
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<button onClick="return form_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交</button>
			</div>
		</div>
	</form>
</article>

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

<script>
    function form_submit()
    {
        name = $("input[name='name']").val();
        if(name.trim() == "" ) {
            layer.msg('请输入模型名称!',{icon:2,time:1000});
            return false;
        }
//        $("#form-article-add").serialize();	//urlencode 形式
        $.ajax({
            type: "GET",
            url: "<?php echo url('admin/Goods/goodsTypeSave','',''); ?>"+'?'+$("#form-article-add").serialize(),
            data: {},
            dataType: "json",
            success: function(json){
                if(json.code == 0){
                    layer.msg('操作成功',{icon:1,time:1000});
                    layer_close();
                    parentReload();
                } else {
                    layer.msg('操作失败',{icon:2,time:1000});
                }
            }
        });
    }
</script>

</body>
</html>
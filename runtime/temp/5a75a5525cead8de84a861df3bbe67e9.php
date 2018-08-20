<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"E:\shopweb\pay.mz211.com/application/mobile\view\goods\category.html";i:1533373049;s:68:"E:\shopweb\pay.mz211.com/application/mobile\view\common\_header.html";i:1533372786;}*/ ?>
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
<link rel="stylesheet" href="/static/mobile/category/css/mob.common.min.css"/>
<style type="text/css">
    /*html, body {*/
    /*height: 100%;*/
    /*position: relative;*/
    /*overflow: hidden;*/
    /*}*/

    .category {
        height: 100%;
        background: #fff;
        overflow: hidden;
    }

    .category nav {
        width: 4rem;
        float: left;
    }

    .category nav ul {
        background: #f8f8f8;
    }

    .category nav ul li {
        height: 49px;
        overflow: hidden;
        border-bottom: solid 1px #ddd;
    }

    .category nav ul li a {
        display: block;
        height: 49px;
        line-height: 49px;
        text-align: center;
        font-size: 14px;
        border-right: solid 1px #ddd;
        border-left: solid 3px #f8f8f8;
    }

    .category nav ul li.current a {
        border-left-color: #da0000;
        border-right-color: #fff;
        color: #da0000;
        background: #fff;
    }

    .category section {
        margin-left: 4rem;
    }

    .category section .category-list {
        padding-left: 0.375rem;
        padding-right: 0.375rem;
    }

    .category section ul {
        padding-top: 0.3rem;
        padding-bottom: 0.3rem;
    }

    .category section ul.current {
        display: block;
    }

    .category section ul li {
        width: 33.3%;
        padding: 0.45rem 0;
        text-align: center;
        float: left;
    }

    .category section ul li a {
        display: block;
    }

    .category section ul li img {
        width: 50px;
        height: 52px;
    }

    .category section ul li span {
        display: block;
        height: 20px;
        overflow: hidden;
        margin-top: 5px;
    }
</style>
<body class="font" id="body">
<div id="top" class="white pos_rel"><h2 class="txt_c f36 white_gray">分类</h2><span class="top_back pos_abs f32"><a class="go_back white">返回</a></span><a class="top_set pos_abs" href="#"></a></div>
<style>
    .white_gray{
        font-size:24px;
    }
    .f32{
        font-size: 24px;
    }
    .f32 a{
        font-size: 20px;
    }
</style>
<script type="text/javascript">
    !function (a) {
        function b() {
            var b = g.getBoundingClientRect().width;
            b / c > 640 && (b = 640 * c), a.rem = b / 16, g.style.fontSize = a.rem + "px"
        }

        var c, d, e, f = a.document, g = f.documentElement, h = f.querySelector('meta[name="viewport"]'), i = f.querySelector('meta[name="flexible"]');
        if (h) {
            console.warn("将根据已有的meta标签来设置缩放比例");
            var j = h.getAttribute("content").match(/initial-scale=(["']?)([d.]+)1?/);
            j && (d = parseFloat(j[2]), c = parseInt(1 / d))
        } else if (i) {
            var j = i.getAttribute("content").match(/initial-dpr=(["']?)([d.]+)1?/);
            j && (c = parseFloat(j[2]), d = parseFloat((1 / c).toFixed(2)))
        }
        if (!c && !d) {
            var k = (a.navigator.appVersion.match(/android/gi), a.navigator.appVersion.match(/iphone/gi)), c = a.devicePixelRatio;
            c = k ? c >= 3 ? 3 : c >= 2 ? 2 : 1 : 1, d = 1 / c
        }
        if (g.setAttribute("data-dpr", c), !h)if (h = f.createElement("meta"), h.setAttribute("name", "viewport"), h.setAttribute("content", "initial-scale=" + d + ", maximum-scale=" + d + ", minimum-scale=" + d + ", user-scalable=no"), g.firstElementChild) g.firstElementChild.appendChild(h); else {
            var l = f.createElement("div");
            l.appendChild(h), f.write(l.innerHTML)
        }
        a.dpr = c, a.addEventListener("resize", function () {
            clearTimeout(e), e = setTimeout(b, 300)
        }, !1),
            a.addEventListener("pageshow", function (a) {
                a.persisted && (clearTimeout(e), e = setTimeout(b, 300))
            }, !1),
            "complete" === f.readyState ? f.body.style.fontSize = 12 * c + "px" : f.addEventListener("DOMContentLoaded", function () {
                    f.body.setAttribute('fontSize', 12 * c + "px")
                }, !1), b()
    }(window);

    (function (b) {
        var a = b.body;
        var e = navigator.userAgent;
        /in_app_not_header/i.test(e) && (a.className += " app-body-no-header");
        /in_app_not_footer/i.test(e) && (a.className += " app-body-no-footer");
        function d() {
            var g = location.search;
            var f = new Object();
            if (g.indexOf("?") != -1) {
                var j = g.substr(1);
                strs = j.split("&");
                for (var h = 0; h < strs.length; h++) {
                    f[strs[h].split("=")[0]] = (strs[h].split("=")[1])
                }
            }
            return f
        }

        var c = d();
        if (c.APP_NAME && c.APP_NAME == "MLL_ADMIN") {
            a.className += " app-body-no-toolbar"
        }
    })(document);
    window._gaq = window._gaq || [];
    window._ana = window._ana || [];
    _ana.baseTime = new Date().getTime();
    window.$$ = window.$$ || {};
    //资源域名
    $$.__IMG = '<?php echo $SITE_URL; ?>';
    window._onReadyList = window._onReadyList || [];
    window._$_ = function (id) {
        return document.getElementById(id)
    };
</script>
<script type="text/javascript">
    window._onReadyList.push(function () {
        var back = $('#JS_header_left_icon');
    });
</script>
<div id="JS_category_box" class="category clearfix">
    <nav>
        <div id="JS_nav_swiper_container" class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <ul id="JS_nav_swiper_menu">
                        <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $k = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                        <li <?php if($k == '1'): ?> class="current" <?php endif; ?> data-id="<?php echo $vo['id']; ?>" data-key="<?php echo $vo['id']; ?>"><a href="javascript:void(0);"><?php echo $vo['name']; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <section>
        <div class="category-list">
            <div id="JS_body_swiper_container" class="swiper-container">
                <div class="swiper-wrapper">
                    <div id="JS_sub_category_list" class="swiper-slide"></div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="/static/mobile/category/js/mob.base.min.js"></script>
<script type="text/javascript" src="/static/mobile/category/js/swiper-3.3.1.min.js"></script>
<script type="text/javascript">
    //一二级分类信息
    var categoryData = {};
    <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['level'] == '1'): ?>
            categoryData['<?php echo $vo['id']; ?>'] = [];
            <?php if(!(empty($vo['_child']) || (($vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator ) && $vo['_child']->isEmpty()))): if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?>
                    categoryData['<?php echo $voo['parent_id']; ?>'].push({
                            'id': '<?php echo $voo['id']; ?>',
                            'name': '<?php echo $voo['name']; ?>',
                            'url': '<?php echo url('mobile/Goods/goodList',['cat_id'=>$voo['id']]); ?>',
                            'img': 'static/mobile/images/none/pro_default.jpg'
                    });
                <?php endforeach; endif; else: echo "" ;endif; endif; endif; endforeach; endif; else: echo "" ;endif; ?>
    var CT = {
        bodySwiper: {},
        init: function () {
            this.setElementHeight();
            this.setNavSwiper();

            this.rendering(1);
            this.bodySwiper = this.setBodySwiper();

            var that = this,
                parentDom = $('#JS_nav_swiper_menu'),
                childrenDom = $('#JS_body_swiper_container');

            parentDom.on('click', 'li', function () {
                var
                    index = $(this).index(),
                    key = $(this).data('key'),
                    h = this._height || $(this).height();

                parentDom.find('li').removeClass('current').eq(index).addClass('current');

                // 滚动
                that.scrollToCurrentClickItem(key);

                childrenDom.fadeToggle(200, function () {
                    childrenDom.css({
                        transform: "translateY(0px)",
                        "-webkit-transform": "translateY(0px)"
                    });
                    that.rendering(key);
                    childrenDom.fadeToggle(200, function () {
                        childrenDom.css("opacity");
                    })
                })
            });
        },
        setElementHeight: function () {
            // 滚动窗口高度
            var virtualWindowHeight = this.virtualWindowHeight = $(window).height() - $('#JS_mll_header').height();
            // 菜单实际高度
            this.menuHeight = $('#JS_nav_swiper_menu').height();

            $('#JS_category_box').css({'height': virtualWindowHeight + 'px'});
            $('.swiper-container').css({'height': virtualWindowHeight + 'px'});

            return this;
        },
        setNavSwiper: function () {
            var navSwiper = new Swiper('#JS_nav_swiper_container', {
                direction: 'vertical',
                freeMode: true,
                slidesPerView: 'auto',
            });
            $(window).resize(function () {
                setTimeout(function () {
                    navSwiper.update();
                }, 300);
            })
        },
        setBodySwiper: function () {
            var bodySwiper = new Swiper('#JS_body_swiper_container', {
                direction: 'vertical',
                freeMode: true,
                slidesPerView: 'auto',
            });
            $(window).resize(function () {
                setTimeout(function () {
                    bodySwiper.update();
                }, 300);
            });
            return bodySwiper;
        },
        scrollToCurrentClickItem: function (index) {
            var isOver = false;
            if (index <= 1 || isOver) return;
            var currentHeight = (index - 1) * 50, d;
            if (this.menuHeight - currentHeight < this.virtualWindowHeight) {
                d = -1 * (this.menuHeight - this.virtualWindowHeight);
                isOver = true;
            } else {
                d = (index - 1) * 50 * -1;
            }
//            var e = {
//                'transform': 'translate3d(0px, '+d+'px, 0px)',
//                '-webkit-transform': 'translate3d(0px, '+d+'px, 0px)',
//                '-webkit-transition': '0.2s ease 0s',
//                'transition': "0.2s ease 0s"
//            };
//            $('#JS_nav_swiper_container .swiper-wrapper').css(e);
        },
        rendering: function (index) {
            if (!categoryData || !categoryData[index]) return;
            var html = [], data = categoryData[index], that = this;

            html.push('<ul class="clearfix">')
            for (var i = 0, ii = data.length; i < ii; i++) {
                html.push('<li><a href="' + data[i].url + '">');
                html.push('<img src="' + $$.__IMG + '/' + data[i].img + '" />');
                var name = data[i].name;
                if (name.length > 6) name = name.substr(0, 6) + '...';
                html.push('<span>' + name + '</span>');
                html.push('</a></li>');
            }
            html.push('</ul>');

            $('#JS_sub_category_list').html(html.join(''));
            setTimeout(function () {
                that.bodySwiper.update(true);
                that.bodySwiper.slideTo(0, 0, false);
            }, 300);
        }
    };
    CT.init();
</script>
<script>
    //返回
    $(".go_back").live('click',function () {
        window.history.go(-1);
    });
</script>
</body>
</html>
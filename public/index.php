<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


function ddd($variable,$exit=false){
    echo '<pre style="background-color:#DFDFDF;color:#666;font-size:14px;font-weight:bold;">
';
    print_r($variable);
    echo '
</pre>';
    if($exit) {
        exit(0);
    }
}

// [ 应用入口文件 ]

// 定义站点根路径
define('SITE_PATH', dirname(dirname(__FILE__)).'/');

//定义网站url
define('SITE_DOMAIN',$_SERVER['HTTP_HOST'] . '/');
define('SITE_URL',$_SERVER['REQUEST_SCHEME'] . '://' . SITE_DOMAIN);

// 定义应用目录
define('APP_PATH', SITE_PATH . 'application/');

// 定义配置文件目录和应用目录同级
define('CONF_PATH', SITE_PATH.'conf/');

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';

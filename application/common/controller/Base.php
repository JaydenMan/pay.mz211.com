<?php

namespace app\common\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    //请求数据
    protected $rqData = array();
    protected $method = null;

    public function _initialize()
    {
        $this->rqData = Request::instance()->param();
        $this->method = Request::instance()->method();
    }

    /* 正确获取值 若不存在则使用默认 */
    public function getVal($data, $key, $default = '') {
        if (empty($key) || empty($data) || !isset($data[$key])) {
            return $default;
        }
        return $data[$key];
    }


    //检查是否在微信浏览器访问
    public function isWeiXinBrowser()
    {
        $userAgent = Request::instance()->server('HTTP_USER_AGENT','');
        return strpos($userAgent, 'MicroMessenger') !== false;
    }

}

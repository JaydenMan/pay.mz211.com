<?php

namespace app\common\controller;

use think\Request;
use think\Session;

class WapBase extends Base
{
    protected $user = array();
    protected $isWxBrowser = false;

//    protected $sessionClass = null;

    public function _initialize()
    {
        parent::_initialize();
//        $this->sessionClass = new WapSession();
        $this->user = Session::get('user', 'wap');
        if (empty($this->user)) {
//            测试
            $this->user = [
                'user_id' => 2,
                'nickname' => '本地测试人员Jcai',
                'oauth' => 'weixin',
                'openid' => 'oXVw40ncIFKjoP62KsunWPKAbBQo',
                'level' => 1,
                'last_login' => 1531271957,
                'is_vip' => 0,
            ];
            Session::set('user',$this->user,'wap');

//            // #############    正式    ###################
//            $url = url('mobile/OpenEntry/index');
//            if(!empty(Request::instance()->server('HTTP_REFERER'))) $url .= '?redirect_uri='.urlencode(Request::instance()->server('HTTP_REFERER'));
//            if (Request::instance()->isAjax()) {
//                $data = ['code' => 9999, 'msg' => '用户未登录', 'data' => ['url' => $url]];
//                exit(json_encode($data));
//            }
//            $this->redirect($url);
//            // #############    正式    ###################
        }
    }

    public function isLogin()
    {
        return array();
    }

}

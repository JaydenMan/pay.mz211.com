<?php

namespace app\mobile\controller;

use app\common\controller\Base;

class OpenEntry extends Base
{
    //第三方登录界面
    public function index()
    {
        $redirectUri = $this->getVal($this->rqData,'redirect_uri','');
        if($this->isWeiXinBrowser()){
            $url = url('mobile/Login/oauth',['entry_way' => 'weixin']);
            if(!empty($redirectUri)) $url .= '?redirect_uri='.$redirectUri;
            $this->redirect($url);
        }
        $this->assign('redirect_uri',urlencode($redirectUri));
        return $this->fetch();
    }

}
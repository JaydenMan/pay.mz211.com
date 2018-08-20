<?php
namespace app\mobile\controller;

use app\common\controller\Base;
use think\Session;

class Login extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    protected function getLoginClass($entry_way)
    {
        // 请求授权，微信特殊情况
        $entryWay = $this->isWeiXinBrowser() ? 'weixin' : $entry_way;
        $UpEntryWay = ucfirst(strtolower($entryWay));
        $loginClass = "\\login\\$entryWay\\$UpEntryWay";
        if(!class_exists($loginClass)) exit('操作有误!');
        return new $loginClass();
    }

    //授权
    public function oauth($entry_way)
    {
        $loginCls = $this->getLoginClass($entry_way);
        $this->redirect($loginCls->getAuthorizeUrl($this->getVal($this->rqData,'redirect_uri','')));
    }

    //第三方登录回调
    public function login()
    {
        //微信,qq登录授权登录，//如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。
        //http://pay.mz211.com/login/qq?code=48FE688821E7F1BE75C861FDF90E0150&state=imall%23qq_redirect
        $entryWay = $this->getVal($this->rqData,'entry_way','');
        $code = $this->getVal($this->rqData,'code','');
        $state = $this->getVal($this->rqData,'state','');
        $redirectUri = $this->getVal($this->rqData,'redirect_uri','');
        if(empty($entryWay) ||  empty($code)) exit('登录失败');
        $loginCls = $this->getLoginClass($entryWay);
        $user = $loginCls->login($code,$entryWay);
        Session::set('user',$user,'wap');
        if(!empty($redirectUri)) {
            $this->redirect($redirectUri);
        } else {
            $this->redirect(url('mobile/User/userCenter'));
        }
    }

}
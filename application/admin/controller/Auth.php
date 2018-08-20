<?php
namespace app\admin\controller;


use app\common\controller\Base;
use think\Session;

class Auth extends Base
{
    protected $adminUser;
    public function _initialize()
    {
        parent::_initialize();
        defined('IS_LOGIN') || define('IS_LOGIN',$this->isLogin());
        if(!IS_LOGIN) {
            $this->redirect('admin/Login/login');
            exit;
        }
    }

    //判断管理员是否登录状态
    public function isLogin()
    {
        $this->adminUser = Session::get('adminUser');
        return !empty($this->adminUser);
    }

}
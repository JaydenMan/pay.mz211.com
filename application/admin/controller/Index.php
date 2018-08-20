<?php
namespace app\admin\controller;


class Index extends Auth
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $this->assign('adminUser',$this->adminUser);
        return $this->fetch();
    }

}
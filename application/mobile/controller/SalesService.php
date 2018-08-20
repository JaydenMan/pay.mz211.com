<?php
namespace app\mobile\controller;

use app\common\controller\WapBase;

class SalesService extends WapBase
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function service()
    {
        $this->assign('title','售后');
        return $this->fetch();
    }

}

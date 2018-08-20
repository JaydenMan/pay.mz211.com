<?php
namespace app\admin\controller;

use app\common\controller\Base;

class Cache extends Base
{

    public function clear()
    {
        $this->clearFile();
        $this->redirect(url('admin/Index/index'));
    }

    public function clearFile()
    {

    }

}
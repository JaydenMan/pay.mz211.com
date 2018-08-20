<?php
namespace app\mobile\controller;

use app\common\controller\Base;
use think\Db;
use think\Session;

class Api extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function region()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        $list = Db::name('region')->where('parent_id', $id)->select();
        return $list;
    }

    //省市区三级联动
    public function cacheRegionData($force = false)
    {
        //cache('name',	NULL);  //	删除缓存数据
        $path = SITE_PATH . 'public/static/mobile/plugin/LArea/js/LAreaData1.js';
        if ($force || !file_exists($path)) {
            $list = $this->getRegionList($force);
            $tree = 'var LAreaData=' . json_encode(listToTree($list, 'id', 'parent_id', 'child')) . ';';
            file_put_contents($path, $tree);
        }
    }

    public function getRegionList($force = false)
    {
        $region = cache('region');
        if ($force || empty($region)) {
            $region = Db::name('region')->select();
            cache('region', $region, 86400);
        }
        return $region;
    }

    public function getRegionMap()
    {
        $region = $this->getRegionList();
        $map = [];
        foreach ($region as $key => $val){
            $map[$val['id']] = $val['name'];
        }
        return $map;
    }
}
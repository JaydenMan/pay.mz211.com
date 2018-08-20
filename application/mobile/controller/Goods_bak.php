<?php
namespace app\mobile\controller;

use app\common\controller\Base;
use think\Db;
use think\Response;

class Goods extends Base
{
    protected $pageRow = 10;
    public function _initialize()
    {
        parent::_initialize();
    }

    public function goodList()
    {
        //默认空操作
        $isDefault = (count($this->rqData) == 1 && is_null($this->rqData['cat_id'])) ? 1 : 0;
        //catId与keyword互斥
        $catId = $this->getVal($this->rqData, 'cat_id', '');
        $keyword = $this->getVal($this->rqData, 'keyword', '');
        $condition = $this->getVal($this->rqData, 'condition', '');
        $sort_type = $this->getVal($this->rqData, 'sort_type', 1);
        $p = $this->getVal($this->rqData, 'p', 1);
        $p = $p > 0 ? $p : 1;
        $list = array();
        $listCount = 0;
        $map = [];
        if ($isDefault) {
            $map['is_on_sale'] = 1;
            $listCount = Db::name('goods')->where($map)->count();
            $list = Db::name('goods')->where($map)->order(['sales_sum' => 'desc'])->limit($this->pageRow * ($p - 1), $this->pageRow)->select();
        } elseif (!empty($catId)) {
            $map = ['cat_id' => $catId, 'is_on_sale' => 1];
            $listCount = Db::name('goods')->where($map)->count();
            $list = Db::name('goods')->where($map)->order(['sales_sum' => 'desc'])->limit($this->pageRow * ($p - 1), $this->pageRow)->select();
        } else if(!empty($keyword)){
            $map = ['goods_name' => ['like',"%{$keyword}%"], 'is_on_sale' => 1];
            $listCount = Db::name('goods')->where($map)->count();
            $list = Db::name('goods')->where($map)->order(['sales_sum' => 'desc'])->limit($this->pageRow * ($p - 1), $this->pageRow)->select();
        }

        //测试
        $list = $this->testStr($list);
        $this->assign('SITE_URL', SITE_URL);
        $this->assign('is_default', $isDefault);
        $this->assign('cat_id', $catId);
        $this->assign('keyword', $keyword);
        $this->assign('condition', $condition);
        $this->assign('sort_type', $sort_type);
        $this->assign('p', $p);
        $this->assign('list_count', $listCount);
        $this->assign('list', $list);
        $this->assign('title', '商品列表');
        return $this->fetch();
    }

    public function ajaxGoodList()
    {
        $map = $this->getMapCondition();
        $order = $this->getOrderCondition();
        $p = $this->getVal($this->rqData, 'p', 1);
        $p = $p > 0 ? $p : 1;
//        $listCount = Db::name('goods')->where($map)->count();
        $list = Db::name('goods')->where($map)->order($order)->limit($this->pageRow * ($p - 1), $this->pageRow)->select();
        //测试
        $list = $this->testStr($list);
        return $list;
    }

    protected function getMapCondition()
    {
        $catId = $this->getVal($this->rqData, 'cat_id', '');
        $keyword = $this->getVal($this->rqData, 'keyword', '');
        $map = ['is_on_sale' => 1];
        $catId && $map['cat_id'] = $catId;
        if ($keyword) {
            if (isset($map['cat_id'])) unset($map['cat_id']);
            //正式可以要改为keywords
            $map['goods_name'] = ['like', "%{$keyword}%"];
//            $map['keywords'] = ['like', "%{$keyword}%"];
        }
        return $map;
    }

    protected function getOrderCondition()
    {
        $condition = $this->getVal($this->rqData, 'condition', '');
        $sort_type = $this->getVal($this->rqData, 'sort_type', '');
        $order = [];
        $sort_type = ($sort_type == 0) ? 'ASC' : 'DESC';
        //排序条件
        switch ($condition) {
            case 0 :
                $order = ['sales_sum' => $sort_type];
                break;
            case 1 :
                $order = ['sales_sum' => $sort_type];
                break;
            case 2 :
                $order = ['click_count' => $sort_type];
                break;
            case 3 :
                $order = ['shop_price' => $sort_type];
                break;
            case 4 :
                $order = ['on_time' => $sort_type];
                break;
            default:
                ;
        }
        return $order;
    }

    public function category()
    {
        $this->assign('title', '分类列表');

        $categoryList = Db::name('goods_category')->select();
        //从第二级开始
        $cateList = [];
        foreach ($categoryList as $k => $v) {
//            if($v['level'] == 1) continue;
            if ($v['level'] == 1) {
                //分类定级
                $cateList[$v['id']] = $v;
            } else if ($v['level'] == 2) {
                if (isset($cateList[$v['parent_id']])) {
                    $cateList[$v['parent_id']]['_child'][$v['id']] = $v;
                }
            }
        }
        $this->assign('SITE_URL', SITE_URL);
        $this->assign('cateList', $cateList);
        return $this->fetch();
    }

    public function goodsInfo()
    {
        $goodsId = $this->getVal($this->rqData,'goods_id');
        if(empty($goodsId)) $this->error('操作有误');
        $goodsInfo = Db::name('goods')->where(['goods_id' => $goodsId,'is_on_sale' => 1])->find();
        if(empty($goodsInfo)) $this->error('商品不存在或已下架');

        $specInfo = Db::name('spec_goods_price')->where('goods_id',$goodsId)->select();

        //规格列表,购物车通过 每个 ，id_id_id 组成 spec_goods_price的key， (i_spec_item.`spec_id`=i_spec_goods_price.`key`)
        //再通过key找到对应的物品项唯一item_id保存到购物车里
        $specList = $this->getSpec($goodsId);

//        ddd($specList);

        $this->assign('title', '商品详情');
        $this->assign('goods_info', $goodsInfo);
        $this->assign('spec_info', json_encode($specInfo));
        $this->assign('spec_list', json_encode($specList));
        return $this->fetch();
    }

    //获取商品规格在详情页显示
    public function getSpec($goodsId)
    {
        //得到该商品具体的规格项 item_id
        $fieldArr = Db::name('spec_goods_price')->where('goods_id',$goodsId)->field('key')->select();
        $itemId = [];
        if(!empty($fieldArr)){
            foreach ($fieldArr as $val){
                $itemId = array_merge($itemId,explode('_',$val['key']));
            }
            $itemId = array_unique($itemId,SORT_STRING);
        }
        $itemStr = '\''.implode('\',\'',$itemId).'\'';
        $prefix = \think\Config::get('database.prefix');
        //i_spec => i_spec_item一对多关系
        $sql = "SELECT a.`name`,a.`order`,b.* FROM `{$prefix}spec` AS a INNER JOIN `{$prefix}spec_item` AS b 
ON a.`id`=b.`spec_id` WHERE b.`id` IN ($itemStr) ORDER BY b.id ASC";
        $rows = Db::query($sql);
        $ret = [];
        foreach ($rows as $k => $v){
            $ret[$v['name']][] = $v;
        }
        return $ret;
    }

    public function testStr($list)
    {
        foreach ($list as &$val) {
            $val['goods_name'] = mb_substr($val['goods_name'],0,20,'utf-8');
            $val['goods_remark'] = mb_substr($val['goods_remark'],0,20,'utf-8');
        }
        return $list;
    }
}

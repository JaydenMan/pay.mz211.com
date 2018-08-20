<?php
namespace app\mobile\controller;

use app\common\controller\Base;
use think\Db;
use think\Request;

class Index extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    //首页
    public function index($type='recommend')
    {
//        $type = $this->getVal($this->rqData,'type','recommend');
        $map = ['parent_id'=>0,'is_show'=>1];
        //商品分类
        $goodsCategory = Db::name('goods_category')->where($map)->order('sort_order','asc')->select();
        //热销，新品商品列表
        $goodMap = $order = [];
        $goodMap['is_on_sale'] = 1;
        switch ($type){
            case 'sales' :
                $order['sales_sum'] = 'desc';
                break;
            case 'click' :
                $order['click_count'] = 'desc';
                break;
            case 'new' :
                $goodMap['is_new'] = 1;
                break;
            default :
                $goodMap['is_recommend'] = 1;
                break;
        }
        $order['sort'] = 'asc';
        $goodsList = Db::name('goods')->where($goodMap)->order($order)->limit(5)->select();

        //测试
        $goodsList = $this->testStr($goodsList);

        $this->assign('title','首页');
        $this->assign('type',$type);
        $this->assign('goodsCategory',$goodsCategory);
        $this->assign('goodsList',$goodsList);
        return $this->fetch();
    }

    public function testStr($list)
    {
        foreach ($list as &$val) {
            $val['goods_name'] = mb_substr($val['goods_name'],0,10,'utf-8');
            $val['goods_remark'] = mb_substr($val['goods_remark'],0,20,'utf-8');
        }
        return $list;
    }

    //首页切换
//    public function show()
//    {
//        $type = $this->getVal($this->rqData,'type','sales');
//        $map = ['parent_id'=>0,'is_show'=>1];
//        //商品分类
//        $goodsCategory = Db::name('goods_category')->where($map)->order('sort_order','asc')->select();
//        //热销，新品商品列表
//        $goodMap = $order = [];
//        $goodMap['is_on_sale'] = 1;
//        switch ($type){
//            case 'sales' :
//                $order['sales_sum'] = 'desc';
//                break;
//            case 'click' :
//                $order['click_count'] = 'desc';
//                break;
//            case 'new' :
//                $goodMap['is_new'] = 1;
//                break;
//            default :
//                $goodMap['is_recommend'] = 1;
//                break;
//        }
//        $order['sort'] = 'asc';
//        $goodsList = Db::name('goods')->where($goodMap)->order($order)->limit(20)->select();
//        $this->assign('title','首页');
//        $this->assign('type',$type);
//        $this->assign('goodsCategory',$goodsCategory);
//        $this->assign('goodsList',$goodsList);
//        return $this->fetch('index');
//    }


}
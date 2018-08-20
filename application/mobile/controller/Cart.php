<?php
namespace app\mobile\controller;

use app\common\controller\WapBase;
use app\mobile\logic\CartLogic;
use app\mobile\model\Pay;
use app\mobile\model\PlaceOrder;
use app\mobile\model\UserAddress;
use think\Db;
use think\Response;

class Cart extends WapBase
{
    public function _initialize()
    {
        parent::_initialize();
        if (empty($this->user)) exit('操作失败');
    }

    public function cart()
    {
        //Db::table('think_user')->alias('a')->join('word b','a.id=b.artist_id','LEFT')->join('word2 c','a.id=c.artist_id','LEFT')->select();
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user['user_id']);
        $list = $cartLogic->getAllCartGoods();
//        foreach ($list as $one){
//            //关联数据获取
//            ddd($one->goods->original_img);
//        }
        $this->assign('title', '购物车');
        $this->assign('list', $list);
        return $this->fetch();
    }

    //添加购物车
    public function ajaxAdd()
    {
//        return ['code'=>0 ,'msg'=>'success','data'=>['goods_id'=>'1']];
        $userId = $this->user['user_id'];
        $goodsId = $this->getVal($this->rqData, 'goods_id');
        $goodsNum = $this->getVal($this->rqData, 'goods_num');
        //item_id，spec_id_list有些商品可能没有规格属性
        $itemId = $this->getVal($this->rqData, 'item_id');
        $specIdList = $this->getVal($this->rqData, 'spec_id_list');
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($userId)->setGoodsId($goodsId)->setGoodsNum($goodsNum)->setItemId($itemId)->setGoods($goodsId)->setSpecGoodsPrice($itemId);
        return $cartLogic->add();
    }

    //更新购物车
    public function ajaxUpdate()
    {
        $cartList = $this->getVal($this->rqData, 'cart_list');
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user['user_id']);
        return $cartLogic->updateCart($cartList);
    }

    //数量
    public function ajaxNum()
    {
        $cartId = $this->getVal($this->rqData, 'cart_id');
        $cartNum = $this->getVal($this->rqData, 'num');
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user['user_id']);
        return $cartLogic->updateNum($cartId, $cartNum);
    }

    //删除
    public function ajaxDel()
    {
        $cartId = $this->getVal($this->rqData, 'cart_id');
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user['user_id']);
        return $cartLogic->del($cartId);
    }

    //结算页
    public function analyse()
    {
        //来源
        $from = $this->getVal($this->rqData, 'from');
        //单个商品立即购买参数
        $goodsId = $this->getVal($this->rqData, 'goods_id');
        $itemId = $this->getVal($this->rqData, 'item_id');
        $goodsNum = $this->getVal($this->rqData, 'goods_num');
        $action = $this->getVal($this->rqData, 'action');   //提交订单 ，$action = 'submit';

        //如果是确认订单，附带参数
        $addressId = $this->getVal($this->rqData, 'address_id');
        $note = $this->getVal($this->rqData, 'note');;   //买家留言

        if (!in_array($from, ['buy_now', 'cart', 'address', 'submit'])) $this->error('操作有误');

        $userAddressMod = new UserAddress();
        if (empty($addressId)) {
            $address = $userAddressMod->where(['user_id' => $this->user['user_id'], 'is_default' => 1])->find();
            if (empty($address)) $this->error('请先添加收货地址', 'mobile/User/addressList');
            if (empty($address['consignee']) || empty($address['mobile']) || empty($address['city']) ||
                empty($address['province'])
            ) $this->error('请先完善收货地址', 'mobile/User/addressList');
        } else {
            $address = $userAddressMod->get($addressId);
        }
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user['user_id']);
        $pay = new Pay($this->user['user_id']);
        try {
            $goodsList = [];
            if ($from == 'cart') {
                $goodsList = $cartLogic->getUserCartList(1);
            } else if ($from == 'buy_now') {
                $goodsList = $cartLogic->getGoodsInfo($goodsId, $goodsNum, $itemId);
            }
            $pay->pay($goodsList);
            $pay->setFrom($from);
            $pay->setNote($note);
            $pay->setAddress($address);

            //如果是提交订单
            if ($action == 'submit') {
                $placeOrder = new PlaceOrder($pay);
                //直接购买: {"note":"快点","address_id":"3","goods_id":"41","item_id":"82","goods_num":"1","action":"submit","from":"buy_now"}
                //购物车:{"note":"快点","address_id":"3","action":"submit","from":"cart"}
                $placeOrder->checkPay();
                $placeOrder->addOrder();
                $order = $placeOrder->getOrder();
                //如果是购物车购物，清空已选商品
                if($pay->getFrom() == 'cart'){
                    $cartLogic->clearSelectedGoods();
                }
                $this->redirect(url('mobile/Cart/payShow',['a' => 'submit_succ']));
                exit;
            }

        } catch (\Think\Exception $e) {
            ddd('file：'.$e->getFile().' <br>line:' . $e->getLine().' <br>msg：'.$e->getMessage(), 1);

            $this->error($e->getMessage(), 'mobile/Cart/cart');
        }

        $api = new Api();
        $map = $api->getRegionMap();
        $this->assign('title', '结算');
        $this->assign('map', $map);
        $this->assign('pay', $pay->toArray());
        return $this->fetch();
    }

    //下单成功界面
    public function payShow()
    {
        $a = $this->getVal($this->rqData,'a');
        if($a != 'submit_succ') $this->error('操作有误');
        $this->assign('title','消息');
        return $this->fetch();
    }


}
<?php
namespace app\mobile\controller;

use app\common\controller\WapBase;
use \app\mobile\model\Order as OrderMod;
use think\Db;

class Order extends WapBase
{
    protected $orderMod;

    public function _initialize()
    {
        parent::_initialize();
        $this->orderMod = new OrderMod();
    }

    //未支付订单
    public function unpaid()
    {
        $orderList = $this->orderMod->where(['user_id' => $this->user['user_id'], 'deleted' => 0, 'pay_status' => 0])->order('add_time', 'desc')->select();
        //遍历每个订单
        foreach ($orderList as $key => $order) {
            $orderGoods = $order->orderGoods()->select();
            $orderList[$key]['orderGoods'] = $orderGoods;
            $orderList[$key]['totalCount'] = 0;
            $orderList[$key]['totalFee'] = 0;
            foreach ($orderGoods as $val) {
                $orderList[$key]['totalCount'] += 1;
                $orderList[$key]['totalFee'] += $val['final_price'] * $val['goods_num'];
            }
        }
        $this->assign('title', '待支付');
        $this->assign('orderList', $orderList);
        return $this->fetch();
    }

    public function unfilled()
    {
        $orderList = $this->orderMod->where(['user_id' => $this->user['user_id'], 'deleted' => 0, 'pay_status' => 1])->order('pay_time', 'desc')->select();
        //遍历每个订单
        foreach ($orderList as $key => $order) {
            $orderGoods = $order->orderGoods()->select();
            $orderList[$key]['orderGoods'] = $orderGoods;
            $orderList[$key]['totalCount'] = 0;
            $orderList[$key]['totalFee'] = 0;
            foreach ($orderGoods as $val) {
                $orderList[$key]['totalCount'] += 1;
                $orderList[$key]['totalFee'] += $val['final_price'] * $val['goods_num'];
            }
        }
        $this->assign('title', '待收货');
        $this->assign('orderList', $orderList);
        return $this->fetch();
    }

    public function remark()
    {
        $this->assign('title', '待评价');
        return $this->fetch();
    }

    public function refund()
    {
        $this->assign('title', '返修/退货');
        return $this->fetch();
    }

    //用户订单假删除
    public function del()
    {
        $orderId = $this->getVal($this->rqData, 'order_id');
        $effect = Db::name('order')->where(['order_id' => $orderId, 'user_id' => $this->user['user_id']])->update(['deleted' => 1]);
        return $effect > 0 ? ['code' => 0, 'msg' => '删除成功', 'data' => []] : ['code' => 1, 'msg' => '删除失败', 'data' => []];
    }

    //展示支付方式
    public function showPay()
    {
        $map = [];
        $map['status'] = 1;
        if ($this->isWeiXinBrowser()) {
            //微信js
            $map['pay_code'] = 'weixin';
        } else {
            $map['pay_code'] = ['neq', 'weixin'];
        }
        $id = $this->getVal($this->rqData, 'id');
        $orderSn = $this->getVal($this->rqData, 'order_sn');
        //判断是否已支付

        $wayList = Db::name('payment_config')->where($map)->select();

        $order = $this->orderMod->where(['order_id' => $id, 'user_id' => $this->user['user_id']])->find();
        if (empty($order) || $order->pay_status == 1) $this->error('订单不存在或已支付');
        $this->assign('title', '支付方式');
        $this->assign('order', $order);
        $this->assign('wayList', $wayList);
        return $this->fetch();
    }


}


/**
 * 状态说明 ：
 * 'ORDER_STATUS' => array(
 * 0 => '待确认',
 * 1 => '已确认',
 * 2 => '已收货',
 * 3 => '已取消',
 * 4 => '已完成',//评价完
 * 5 => '已作废',
 * ),
 * 'SHIPPING_STATUS' => array(
 * 0 => '未发货',
 * 1 => '已发货',
 * 2 => '部分发货'
 * ),
 * 'PAY_STATUS' => array(
 * 0 => '未支付',
 * 1 => '已支付',
 * ),
 * 'SEX' => array(
 * 0 => '保密',
 * 1 => '男',
 * 2 => '女'
 * ),
 * 'COUPON_TYPE' => array(
 * 0 => '面额模板',
 * 1 => '按用户发放',
 * 2 => '注册发放',
 * 3 => '邀请发放',
 * 4 => '线下发放'
 * ),
 * 'PROM_TYPE' => array(
 * 0 => '默认',
 * 1 => '抢购',
 * 2 => '团购',
 * 3 => '优惠'
 * ),
 * // 订单用户端显示状态
 * 'WAITPAY'=>' AND pay_status = 0 AND order_status = 0 AND pay_code !="cod" ', //订单查询状态 待支付
 * 'WAITSEND'=>' AND (pay_status=1 ｏｒ pay_code="cod") AND shipping_status !=1 AND order_status in(0,1) ', //订单查询状态 待发货
 * 'WAITRECEIVE'=>' AND shipping_status=1 AND order_status = 1 ', //订单查询状态 待收货
 * 'WAITCCOMMENT'=> ' AND order_status=2 ', // 待评价 确认收货     //'FINISHED'=>'  AND order_status=1 ', //订单查询状态 已完成
 * 'FINISH'=> ' AND order_status = 4 ', // 已完成
 * 'CANCEL'=> ' AND order_status = 3 ', // 已取消
 *
 * 'ORDER_STATUS_DESC' => array(
 * 'WAITPAY' => '待支付',
 * 'WAITSEND'=>'待发货',
 * 'WAITRECEIVE'=>'待收货',
 * 'WAITCCOMMENT'=> '待评价',
 * 'CANCEL'=> '已取消',
 * 'FINISH'=> '已完成', //
 * ),
 *
 *
 * 订单用户端显示按钮
 * 去支付     AND pay_status=0 AND order_status=0 AND pay_code ! ="cod"
 * 取消按钮  AND pay_status=0 AND shipping_status=0 AND order_status=0
 * 确认收货  AND shipping_status=1 AND order_status=0
 * 评价      AND order_status=1
 * 查看物流  if(!empty(物流单号))
 * 退货按钮（联系客服）  所有退换货操作， 都需要人工介入   不支持在线退换货
 */
<?php

namespace app\mobile\model;
use think\Cache;
use think\Db;
use think\Exception;
use think\Model;

/**
 * 下单类
 *
 */
class PlaceOrder
{
    protected $user;
    protected $pay;
    protected $order;
    protected $maxPayNum = 50;

    public function __construct(Pay $pay)
    {
        $this->pay = $pay;
    }

    /**
     * 检查数据
     */
    public function checkPay()
    {
        if(empty($this->pay)) throw new Exception('数据异常',1);
        if(empty($this->pay->getUserId())) throw new Exception('订单超时',1);
        if(empty($this->pay->getAddress())) throw new Exception('请选择你的收货地址',1);
        if(empty($this->pay->getAddress()->mobile) || empty($this->pay->getAddress()->consignee) || empty($this->pay->getAddress()->province)) throw new Exception('请先完善收货地址',1);
        if(empty($this->pay->getPayList())) throw new Exception('请先选择商品',1);
        return true;
    }

    /**
     * 生成订单
     */
    public function addOrder()
    {
        $currentNum = Cache::get('place_order');
        if($currentNum > $this->maxPayNum){
            throw new Exception('当前人数较多，稍后再试吧！',2);
        }
        //队列控制
        Cache::inc('place_order');
        $orderMod = new Order();
        $orderNumber = $orderMod->createOrderNumber();
        $address = $this->pay->getAddress();
        $orderData = [
            'order_sn' => $orderNumber,
            'user_id' => $this->pay->getUserId(),
            'order_status' => 0,    //订单状态
            'shipping_status' => 0,     //发货状态
            'pay_status' => 0,  //支付状态
            'consignee' => $address['consignee'],
            'province' => $address['province'],
            'city' => $address['city'],
            'district' => $address['district'],
            'town' => $address['town'],
            'address' => $address['address'],
            'mobile' => $address['mobile'],
            'goods_price' => $this->pay->getTotalFee(),     //商品总价
            'shipping_price' => 0,       //邮费
            'order_amount' => $this->pay->getFinalFee(),       //应付款金额
            'total_amount' => $this->pay->getTotalFee(),       //订单总价
            'add_time' => time(),       //下单时间
            'prom_type' => 0,       //订单类型,0普通订单
            'user_note' => 0,       //用户备注
        ];
        if($orderMod->data($orderData)->save() == 0) throw new Exception('下单失败,稍后再试！',2);
        $this->order = $orderMod->get($orderMod->order_id);

        //增加订单商品表信息
        $orderGoods = new OrderGoods();
        $goods = [];
        foreach ($this->pay->getPayList() as $key => $goodsInfo){
            $info['order_id'] = $this->order['order_id'];
            $info['goods_id'] = $goodsInfo['goods_id'];
            $info['goods_name'] = $goodsInfo['goods_name'];
            $info['goods_sn'] = $goodsInfo['goods_sn'];
            $info['goods_num'] = $goodsInfo['goods_num'];
            $info['final_price'] = $goodsInfo['goods_price'];
            $info['goods_price'] = $goodsInfo['goods_price'];
            $info['cost_price'] = 0;    //成本价
            $info['member_goods_price'] = 0;
            $info['spec_key'] = $goodsInfo['spec_key'];
            $info['spec_key_name'] = $goodsInfo['spec_key_name'];
            $info['prom_type'] = 0;     //活动类型
            $info['is_send'] = 0;   //是否已发货
            $goods[] = $info;
        }
        $effect = $orderGoods->saveAll($goods);
        Cache::dec('place_order');
        return true;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {

    }

}

<?php

namespace app\mobile\model;

use app\common\model\WapBase;

class Order extends WapBase
{
    private $prefix = '';
    private $length = 22;

    protected function initialize()
    {
        parent::initialize();
    }

    public function orderGoods()
    {
        //hasMany('关联模型名','外键名','主键名',['模型别名定义']);
        return $this->hasMany('OrderGoods','order_id','order_id');
    }

    public function createOrderNumber()
    {
        $orderNumber = '';
        while (true){
            $number = $this->getOrderNumber();
            if(empty($this->where('order_sn' , $number)->find())){
                $orderNumber = $number;
                break;
            }
        }
        return $orderNumber;
    }

    private function getOrderNumber()
    {
        $num = $this->prefix.date('YmdHis',time());
        //$string = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
        $string = '0123456789';
        while (strlen($num) < $this->length) {
            $num .= $string[mt_rand(0,9)];
        }
        return $num;
    }
}

<?php

namespace app\mobile\model;

use app\common\model\WapBase;

class Cart extends WapBase
{

    protected function initialize()
    {
        parent::initialize();
    }

    //关联模型 goods
    public function goods()
    {
//        hasMany('关联模型名','外键名','主键名',['模型别名定义']);
        return $this->hasOne('Goods', 'goods_id', 'goods_id')->field('goods_id,goods_sn,goods_name,store_count,market_price,shop_price,original_img,is_on_sale');
    }
    
}

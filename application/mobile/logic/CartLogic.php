<?php

namespace app\mobile\logic;

use app\common\model\WapBase;
use app\mobile\model\Cart;
use app\mobile\model\Goods;
use app\mobile\model\SpecGoodsPrice;
use think\Db;
use think\Exception;

class CartLogic extends WapBase
{
    protected $userId;
    protected $goodsId;
    protected $goodsNum;
    protected $itemId;
    protected $goods;   //goods模型
    protected $specGoodsPrice;      //spec_goods_price模型


    protected function initialize()
    {
        parent::initialize();
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function setGoodsId($goodsId)
    {
        $this->goodsId = $goodsId;
        return $this;
    }

    public function setGoodsNum($goodsNum)
    {
        $this->goodsNum = $goodsNum;
        return $this;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }

    public function setGoods($goodsId)
    {
        if ($goodsId > 0) {
            $goodsMod = new Goods();
            $this->goods = $goodsMod->get($goodsId);
        }
        return $this;
    }

    public function setSpecGoodsPrice($itemId)
    {
        $specGoodsPriceMod = new SpecGoodsPrice();
        if ($itemId > 0) {
            $this->specGoodsPrice = $specGoodsPriceMod->get($itemId);
        }
        return $this;
    }

    //添加商品到购物车
    public function add()
    {
        //判断商品是否存在
        if (empty($this->goods)) {
            return ['code' => 1, 'msg' => '商品不存在', 'data' => ['goods_id' => $this->goodsId]];
        }
        $cartMod = new Cart();
        $count = $cartMod->where('user_id', $this->userId)->count();

        //购物车商品种类数量限制200
        if ($count >= 200) {
            return ['code' => 2, 'msg' => '购物车已满，请先清理购物车', 'data' => []];
        }
        $id = 0;
        //区分商品规格是否存在做处理
        if (empty($this->specGoodsPrice)) {
            //不存在规格的商品
            $cart = $cartMod->where(['user_id' => $this->userId, 'goods_id' => $this->goods['goods_id'], 'spec_key' => ''])->find();
            if (!empty($cart)) {
                //该商品规格已存在购物车
                if (($cart->goods_num + $this->goodsNum) > $this->goods->store_count) {
                    $cart->goods_num = $this->goods->store_count;
                } else {
                    $cart->goods_num = $cart->goods_num + $this->goodsNum;
                }
                $cart->add_time = time();
                $id = $cart->save();
            } else {
                //此商品首次添加购物车
                $data = [
                    'user_id' => $this->userId,
                    'goods_id' => $this->goods->goods_id,
                    'goods_sn' => $this->goods->goods_sn,
                    'goods_name' => $this->goods->goods_name,
                    'market_price' => $this->goods->market_price,
                    'goods_price' => $this->goods->shop_price,
                    'member_goods_price' => '',
                    'goods_num' => ($this->goodsNum > $this->goods->store_count ? $this->goods->store_count : $this->goodsNum),
                    'item_id' => '',
                    'spec_key' => '',
                    'add_time' => time(),
                    'prom_type' => 0,
                ];
                $id = $cartMod->data($data)->save();
            }
        } else {
            $cart = $cartMod->where(['user_id' => $this->userId, 'goods_id' => $this->goods['goods_id'], 'spec_key' => $this->specGoodsPrice->key])->find();
            if (!empty($cart)) {
                //该商品规格已存在购物车
                if (($cart->goods_num + $this->goodsNum) > $this->specGoodsPrice->store_count) {
                    $cart->goods_num = $this->specGoodsPrice->store_count;
                } else {
                    $cart->goods_num = $cart->goods_num + $this->goodsNum;
                }
                $cart->add_time = time();
                $id = $cart->save();
            } else {
                //此商品首次添加购物车
                $data = [
                    'user_id' => $this->userId,
                    'goods_id' => $this->goods->goods_id,
                    'goods_sn' => $this->goods->goods_sn,
                    'goods_name' => $this->goods->goods_name,
                    'market_price' => $this->goods->market_price,
                    'goods_price' => $this->specGoodsPrice->price,
                    'member_goods_price' => '',
                    'goods_num' => ($this->goodsNum > $this->specGoodsPrice->store_count ? $this->specGoodsPrice->store_count : $this->goodsNum),
                    'item_id' => $this->specGoodsPrice->item_id,
                    'spec_key' => $this->specGoodsPrice->key,
                    'spec_key_name' => $this->specGoodsPrice->key_name,
                    'add_time' => time(),
                    'prom_type' => 0,
                ];
                $id = $cartMod->data($data)->save();
            }
        }
        return ($id > 0) ? ['code' => 0, 'msg' => '已添加到购物车', 'data' => ['id' => $id, 'goods_id' => $this->goodsId]] :
            ['code' => 4, 'msg' => '添加失败,请稍后再试！', 'data' => ['id' => $id]];
    }

    /**
     * 获取用户购物车信息
     */
    public function getAllCartGoods()
    {
        $cartMod = new Cart();
        return $cartMod->with('goods')->where(['user_id' => $this->userId])->order(['goods_id' => 'asc', 'add_time' => 'desc'])->select();
    }


    /**
     * 更新选中的商品购物车信息
     * @param $cartList
     * @return array
     */
    public function updateCart($cartList)
    {
        $cartMod = new Cart();
        $id = 0;
        $totalFee = 0;
        $totalItemNum = 0;
        //全部更新为未选
        $cartMod->where('user_id', $this->userId)->update(['selected' => 0]);
        foreach ($cartList as $key => $_cart) {
            //区分商品规格是否存在做处理
            $cart = $cartMod->with('goods')->where('id', $_cart['cart_id'])->find();
            //错误操作
            if (empty($cart)) return ['code' => 4, 'msg' => '更新失败！', 'data' => []];;
            $specGoodsPrice = null;
            if ($cart['item_id'] > 0) {
                //查找商品规格
                $specGoodsPrice = Db::name('spec_goods_price')->where('item_id', $cart['item_id'])->find();
            }
            if (!empty($specGoodsPrice)) {
                //有规格商品
                if (($cart->goods_num + $_cart['goods_num']) > $specGoodsPrice['store_count']) {
                    $cart->goods_num = $specGoodsPrice['store_count'];
                } else {
                    $cart->goods_num = $_cart['goods_num'];
                }
                $cartList[$key]['goods_num'] = $cart->goods_num;
                $cart->add_time = time();
                $cart->selected = 1;
                $totalFee += $cart->goods_price * $cart->goods_num;
                //删除关联模型字段
                unset($cart->goods);
                $id = $cart->save();
            } else {
                //没有规格商品
                if (($cart->goods_num + $_cart['goods_num']) > $cart->goods->store_count) {
                    $cart->goods_num = $cart->goods->store_count;
                } else {
                    $cart->goods_num = $_cart['goods_num'];
                }
                $cartList[$key]['goods_num'] = $cart->goods_num;
                $cart->add_time = time();
                $cart->selected = 1;
                $totalFee += $cart->goods_price * $cart->goods_num;
                unset($cart->goods);
                $id = $cart->save();
            }
            $totalItemNum += 1;
        }
        return ($id > 0) ? ['code' => 0, 'msg' => '已更新购物车', 'data' => ['cartList' => $cartList, 'totalFee' => $totalFee, 'totalItemNum' => $totalItemNum]] :
            ['code' => 4, 'msg' => '更新失败！', 'data' => []];
    }

    //更新单个物品数量
    public function updateNum($cartId, $cartNum)
    {
        $cartMod = new Cart();
        $cart = $cartMod->with('goods')->where('id', $cartId)->find();
        //错误操作
        if (empty($cart)) return ['code' => 4, 'msg' => '更新失败！', 'data' => []];;
        $specGoodsPrice = null;
        if ($cart['item_id'] > 0) {
            //存在规格的商品
            $specGoodsPrice = Db::name('spec_goods_price')->where('item_id', $cart['item_id'])->find();
        }
        $ret = [];
        if (!empty($specGoodsPrice)) {
            if ($cartNum > $specGoodsPrice['store_count']) {
                $cartNum = $specGoodsPrice['store_count'];
                $ret = ['code' => 1, 'msg' => '修改成功', 'data' => ['maxNum' => $cartNum]];
            }
        } else {
            //没有规格商品
            if ($cartNum > $cart->goods->store_count) {
                $cartNum = $cart->goods->store_count;
                $ret = ['code' => 1, 'msg' => '修改成功', 'data' => ['maxNum' => $cartNum]];
            }
        }
        unset($cart->goods);
        $cart->goods_num = $cartNum;
        $row = $cart->data(['goods_num' => $cartNum])->save();
        return !empty($ret) ? $ret : ['code' => 0, 'msg' => '修改成功', 'data' => ['row' => $row]];
    }

    //删除
    public function del($cartId)
    {
        $cartMod = new Cart();
        $cart = $cartMod->get($cartId);
        $row = $cart->delete();
        return $row > 0 ? ['code' => 0, 'msg' => '删除成功', 'data' => ['row' => $row]] : ['code' => 4, 'msg' => '更新失败！', 'data' => []];
    }


    /**
     * 获取用户购物车商品
     * @param int $selected
     */
    public function getUserCartList($selected = 1)
    {
        $cartMod = new Cart();
        $cartList = $cartMod->with('goods')->where(['user_id' => $this->userId, 'selected' => $selected])->select();
        if (empty($cartList)) throw new Exception('购物车没有选择商品', 1);
        $list = [];
        foreach ($cartList as $cart) {
            //区分商品规格是否存在做处理
            $goodsInfo = [];
            $goodsInfo['user_id'] = $this->userId;
            $goodsInfo['goods_id'] = $cart['goods']['goods_id'];
            $goodsInfo['goods_sn'] = $cart['goods']['goods_sn'];
            $goodsInfo['goods_name'] = $cart['goods']['goods_name'];
            $goodsInfo['market_price'] = $cart['goods']['market_price'];
            $goodsInfo['member_goods_price'] = 0;
            $goodsInfo['original_img'] = $cart['goods']['original_img'];
            //以下区分规格参数
            $goodsInfo['goods_price'] = $cart['goods']['shop_price'];
            $goodsInfo['goods_num'] = 1;
            $goodsInfo['item_id'] = 0;
            $goodsInfo['spec_key'] = '';
            $goodsInfo['spec_key_name'] = '';

            $specGoodsPrice = null;
            if ($cart['item_id'] > 0) {
                //查找商品规格
                $specGoodsPrice = Db::name('spec_goods_price')->where('item_id', $cart['item_id'])->find();
            }
            //检查商品数量是否小于库存,校验商品价格
            if (!empty($specGoodsPrice)) {
                //有规格商品
                $error = false;
                $cart['goods_price'] = $specGoodsPrice['price'];
                //如果超过库存数量，重置为1
                if ($cart['goods_num'] > $specGoodsPrice['store_count']) {
                    $error = true;
                    $cart['goods_num'] = 1;
                }
                //更新
                $update = ['goods_price' => $cart['goods_price'], 'goods_num' => $cart['goods_num']];
                $cartMod->where('id', $cart['id'])->update($update);
                if ($error) throw new Exception('商品数量超过当前库存，请返回购物车确认', 2);
                $goodsInfo['goods_price'] = $specGoodsPrice['price'];
                $goodsInfo['goods_num'] = $cart['goods_num'];
                $goodsInfo['item_id'] = $specGoodsPrice['item_id'];
                $goodsInfo['spec_key'] = $specGoodsPrice['key'];
                $goodsInfo['spec_key_name'] = $specGoodsPrice['key_name'];
            } else {
                $error = false;
                //没有规格商品
                $cart['goods_price'] = $cart['goods']['shop_price'];
                if ($cart['goods_num'] > $cart['goods']['store_count']) {
                    $cart['goods_num'] = 1;
                    $error = true;
                }
                $update = ['goods_price' => $cart['goods_price'], 'goods_num' => $cart['goods_num']];
                $cartMod->where('id', $cart['id'])->update($update);
                if ($error) throw new Exception('商品数量超过当前库存，请返回购物车确认', 2);
                $goodsInfo['goods_num']  = $cart['goods_num'];
            }
            $list[] = $goodsInfo;
        }
        return $list;
    }


    /**
     * 立即购买商品分析
     * @param $goodsId
     * @param $goodsNum
     * @param string $itemId
     */
    public function getGoodsInfo($goodsId,$goodsNum,$itemId = 0)
    {
        $this->setGoods($goodsId)->setGoodsNum($goodsNum)->setItemId($itemId);
        if(empty($this->goods)) throw new Exception('操作有误商品不存在',1);
        //下单商品数据
        $goodsInfo =  [];
        $goodsInfo['user_id'] = $this->userId;
        $goodsInfo['goods_id'] = $this->goods->goods_id;
        $goodsInfo['goods_sn'] = $this->goods->goods_sn;
        $goodsInfo['goods_name'] = $this->goods->goods_name;
        $goodsInfo['market_price'] = $this->goods->market_price;
        $goodsInfo['member_goods_price'] = 0;
        $goodsInfo['original_img'] = $this->goods->original_img;
        //一下为区分规格参数
        $goodsInfo['goods_price'] = $this->goods->shop_price;
        $goodsInfo['goods_num'] = 1;
        $goodsInfo['item_id'] = 0;
        $goodsInfo['spec_key'] = '';
        $goodsInfo['spec_key_name'] = '';
        $specGoodsPrice = null;
        if ($this->itemId > 0) $specGoodsPrice = Db::name('spec_goods_price')->where('item_id', $this->itemId)->find();
        if (!empty($specGoodsPrice)) {
            //有规格商品
            if ($goodsNum > $specGoodsPrice['store_count']) $goodsNum = $specGoodsPrice['store_count'];
            $goodsInfo['goods_price'] = $specGoodsPrice['price'];
            $goodsInfo['goods_num'] = $goodsNum;
            $goodsInfo['item_id'] = $specGoodsPrice['item_id'];
            $goodsInfo['spec_key'] = $specGoodsPrice['key'];
            $goodsInfo['spec_key_name'] = $specGoodsPrice['key_name'];
        } else {
            $goodsInfo['goods_price'] = $this->goods->shop_price;
            if($goodsNum > $this->goods->store_count) $goodsNum = $this->goods->store_count;
            $goodsInfo['goods_num'] = $goodsNum;
        }
        //相同格式返回
        return [$goodsInfo];
    }

    /**
     * 清空用户已选购物车
     * @return int
     */
    public function clearSelectedGoods()
    {
        return Db::name('cart')->where(['user_id'=>$this->userId,'selected'=>1])->delete();
    }

}

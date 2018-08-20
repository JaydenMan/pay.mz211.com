<?php

namespace app\mobile\model;
use think\Db;
use think\Exception;
use think\Model;

/**
 * 结算类,统计分析预订单的数据
 * Class Pay
 * @package app\mobile\model
 */
class Pay
{
    protected $userId;
    protected $payList;     //商品列表
    protected $address;
    protected $totalFee = 0;    //商品总价
    protected $finalFee = 0;    //支付总价;
    protected $totalCount = 0;
    protected $from = 'cart';
    protected $note = '';

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getPayList()
    {
        return $this->payList;
    }

    /**
     * @param mixed $payList
     */
    public function setPayList($payList)
    {
        $this->payList = $payList;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getTotalFee()
    {
        return $this->totalFee;
    }

    /**
     * @param int $totalFee
     */
    public function setTotalFee($totalFee)
    {
        $this->totalFee = $totalFee;
    }

    /**
     * @return int
     */
    public function getFinalFee()
    {
        return $this->finalFee;
    }

    /**
     * @param int $finalFee
     */
    public function setFinalFee($finalFee)
    {
        $this->finalFee = $finalFee;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * 购物车数据统计
     * @param $goodsList
     * @throws Exception
     */
    public function pay($goodsList)
    {
        if(empty($goodsList)) throw new Exception('没有选择商品',1);
        $this->payList = $goodsList;
        foreach ($this->payList as $goods){
            $this->totalFee += $goods['goods_price'] * $goods['goods_num'];
            $this->totalCount += 1;
        }
        //暂时无优惠处理
        $this->finalFee = $this->totalFee;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'userId' => $this->userId,
            'totalFee' => $this->totalFee,
            'finalFee' => $this->finalFee,
            'totalCount' => $this->totalCount,
            'payList' => $this->payList,
            'address' => $this->address->toArray(),
            'from' => $this->from,
        ];
    }

}

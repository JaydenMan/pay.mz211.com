<?php
namespace app\mobile\controller;

use app\common\controller\Base;
use app\mobile\model\Order;
use think\Db;
use think\Session;

/**
 * 手机网站第三方支付(包括回调等,继承Base)
 * Class Payment
 * @package app\mobile\controller
 */
class Payment extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    protected function getPaymentClass($code)
    {
        $way = $this->isWeiXinBrowser() ? 'weixin' : $code;
        $upWay = ucfirst(strtolower($way));
        //E:\shopweb\pay.mz211.com\extend\pay\weixin\Weixin.php
        $payClass = "\\pay\\$way\\$upWay";
        if(!class_exists($payClass)) $this->error('操作有误!');
        return new $payClass();
    }

    /**
     * 提交订单,前往支付
     */
    public function pay()
    {
        $user = Session::get('user', 'wap');
        if (empty($user)){
            //未登录
            $this->redirect(url('mobile/OpenEntry/index'));
        }
        $id = $this->getVal($this->rqData,'id');
        $payCode = $this->getVal($this->rqData,'pay_code');

        //微信测试
//        $payCode = 'weixin';
//        $payCode = 'alipay';

        if((int)($id)<1 || empty($payCode)) $this->error('请返回重新操作...');
        $order = Db::name('order')->where(['order_id'=>$id,'user_id'=>$user['user_id'],'pay_status'=>0])->find();
        if(empty($order)) $this->error('订单不存在');
        //更新订单的支付方式
        $config = Db::name('payment_config')->where(['pay_code'=>$payCode,'status'=>1])->find();
        if(empty($config)) $this->error('不支持此支付方式');
        $update = ['pay_code'=>$payCode,'pay_name'=>$config['pay_name']];
        Db::name('order')->where(['order_id'=>$id,'user_id'=>$user['user_id'],'pay_status'=>0])->update($update);
        //获取商品描述信息
        $goodsNameArr = Db::name('order_goods')->where('order_id',$order['order_id'])->column('goods_name');
        //截取最长120个字符
        $goodsIntro = substr(implode(',',$goodsNameArr),0,120);
        $payClass = $this->getPaymentClass($payCode);
        $html = $payClass->gotoPay($user,$order,$goodsIntro);
        return $html;
    }
    
    /**
     * 第三方回调通知请求
     *
     */
    public function notifyUrl()
    {
//        $logPath = SITE_PATH.'public/static/log/notifyUrl.html';
//        file_exists($logPath) && file_put_contents($logPath,date('[Y-m-d H:i:s]').json_encode($_REQUEST,JSON_UNESCAPED_UNICODE)."\r\n",FILE_APPEND);
        $payCode = $this->getVal($this->rqData,'pay_code');
        $payClass = $this->getPaymentClass($payCode);
        $payClass->notify($this);
    }

    //处理第三方回调通知请求钩子,不输出信息
    public function notify($payCode,$data)
    {
        $orderMod = new Order();
        if($payCode == 'alipay'){
            $map = ['order_sn'=>$data['order_sn'],'order_status'=>0,'shipping_status'=>0,'pay_status'=>0];
            $order = $orderMod->where($map)->find();
            if(!empty($order)){
                //未处理支付成功的订单才要更新
                $order->order_status = 1;
                $order->pay_status = 1;
                $order->transaction_id = isset($data['trade_no']) ? $data['trade_no'] : '';
                $order->pay_time = time();
                $order->pay_code = $payCode;
                $order->real_amount = isset($data['total_fee']) ? $data['total_fee'] : 0;
                $order->save();
            }
        } else if($payCode == 'weixin'){

        } else if($payCode == 'weixinh5'){

        }

    }

    /**
     * 第三方支付跳转
     */
    public function returnUrl()
    {
//        $logPath = SITE_PATH.'public/static/log/returnUrl.html';
//        file_exists($logPath) && file_put_contents($logPath,date('[Y-m-d H:i:s]').json_encode($_REQUEST,JSON_UNESCAPED_UNICODE)."\r\n",FILE_APPEND);
        $payCode = $this->getVal($this->rqData,'pay_code');
        if(empty($payCode)) exit('<a style="text-decoration:none;" href="'.url('/').'">返回首页</a>');
        $payClass = $this->getPaymentClass($payCode);
        $payClass->payReturn($this);
    }


    //异步处理第三方支付跳转钩子,输出相应页面
    public function payReturn($payCode,$data)
    {
        if($payCode == 'alipay'){
            if(in_array($data['trade_status'],['TRADE_FINISHED','TRADE_SUCCESS'])){
                echo '支付宝已支付成功<br><br>';
                echo '<a style="text-decoration:none;" href="'.url('mobile/Order/unfilled').'">查看订单</a>';
                echo '<br><br><br><br><br><br><br><br><br>';
            } else {
                echo '支付失败<br><br>';
                echo '<a style="text-decoration:none;" href="'.url('/').'">返回首页</a>';
                echo '<br><br><br><br><br><br><br><br><br>';
            }
            ddd($_REQUEST);
        } else if($payCode == 'weixin'){
            echo '微信支付成功<br><br>';
            ddd($_REQUEST);
        } else if($payCode == 'weixinh5'){
            echo '微信H5支付成功<br><br>';
            ddd($_REQUEST);
        }
    }
}

/**
状态说明 ：
'ORDER_STATUS' => array(
0 => '待确认',
1 => '已确认',
2 => '已收货',
3 => '已取消',
4 => '已完成',//评价完
5 => '已作废',
),
'SHIPPING_STATUS' => array(
0 => '未发货',
1 => '已发货',
2 => '部分发货'
),
'PAY_STATUS' => array(
0 => '未支付',
1 => '已支付',
),
 */
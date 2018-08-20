<?php
namespace app\mobile\controller;

use app\common\controller\WapBase;
use app\mobile\model\UserAddress;
use think\Db;
use think\Request;
use think\Session;

class User extends WapBase
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function userCenter()
    {

        $this->assign('title', '个人中心');
        $this->assign('user', $this->user);
        return $this->fetch();
    }

    //收货地址
    public function addressList()
    {
        $userAddressMod = new UserAddress();
        $list = $userAddressMod->where('user_id', $this->user['user_id'])->select();
        $api = new Api();
        $region = $api->getRegionMap();
        $this->assign('title', '地址');
        $this->assign('list', $list);
        $this->assign('region', $region);
        return $this->fetch();
    }

    public function addAddress()
    {
        $api = new Api();
        $api->cacheRegionData();
        $id = $this->getVal($this->rqData, 'id', 0);
        if (intval($id) > 0) {
            $userAddressMod = new UserAddress();
            $userAddress = $userAddressMod->get($id);
            $api = new Api();
            $region = $api->getRegionMap();
            $this->assign('userAddress', $userAddress);
            $this->assign('region', $region);
        }
        $this->assign('title', '收货地址');
        return $this->fetch();
    }

    /**
     * 添加、更新收货地址
     * @return bool
     */
    public function saveAddress()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        $consignee = $this->getVal($this->rqData, 'consignee');
        $mobile = $this->getVal($this->rqData, 'mobile');
        $pcd = $this->getVal($this->rqData, 'pcd');
        $address = $this->getVal($this->rqData, 'address');
        $is_default = $this->getVal($this->rqData, 'is_default');

        $arr = explode(',', $pcd);
        $province = isset($arr[0]) ? $arr[0] : 0;
        $city = isset($arr[1]) ? $arr[1] : 0;
        $district = isset($arr[2]) ? $arr[2] : 0;
        $data = [
            'user_id' => $this->user['user_id'],
            'consignee' => $consignee,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'mobile' => $mobile,
            'address' => $address,
            'is_default' => $is_default,
        ];
        $userAddressMod = new UserAddress();
        if (!empty($id)) {
            //更新操作
            $userAddress = $userAddressMod->get($id);
            if ($is_default == 1) {
                Db::name('user_address')->where('user_id', $this->user['user_id'])->update(['is_default' => 0]);
            } else {
                $count = $userAddress->where('user_id', $this->user['user_id'])->count();
                $data['is_default'] = ($count == 0) ? 1 : $is_default;
            }
            $res = $userAddress->save($data);       //不能->data($data)->save();更新
        } else {
            if ($data['is_default'] == 1) {
                $userAddressMod->where('user_id', $this->user['user_id'])->update(['is_default' => 0]);
            } else {
                $count = $userAddressMod->where('user_id', $this->user['user_id'])->count();
                $data['is_default'] = ($count == 0) ? 1 : 0;
            }
            $res = $userAddressMod->data($data)->save();
        }
        if ($res > 0) {
            $this->success('操作成功', 'mobile/User/addressList');
        } else {
            $this->error('操作失败');
        }
    }


}

<?php

namespace app\mobile\model;

use app\common\model\WapBase;

class User extends WapBase
{
    //	设置当前模型对应的完整数据表名称
//    protected $table = 'i_user';

    public $sessData = array(
        'user_id' => 0,
        'nickname' => '',
        'oauth' => '',
        'openid' => '',
        'level' => 1,
        'last_login' => 0,
        'is_vip' => 0,
    );

    protected function initialize()
    {
        parent::initialize();
    }

    //注册
    public function register($data)
    {
        if(!isset($data['oauth']) || !in_array($data['oauth'],$this->oauthArr)) {
            return array();
        }
        $this->oauthType = $data['oauth'];
        $ret = array();
        if(method_exists($this, ucfirst($this->oauthType).'Register')){
            $ret = call_user_func_array(array($this, ucfirst($this->oauthType).'Register'),array($data));
        }
        return $ret;
    }

    //登录
    public function login($data)
    {
        if(!isset($data['oauth']) || !in_array($data['oauth'],$this->oauthArr)) {
            return array();
        }
        $this->oauthType = $data['oauth'];
        $ret = array();
        if(method_exists($this, ucfirst($this->oauthType).'Login')){
            $ret = call_user_func_array(array($this, ucfirst($this->oauthType).'Login'),array($data));
        }
        return $ret;
    }

    public function setSessData($user)
    {
        $this->sessData['user_id'] = $user->user_id;
        $this->sessData['nickname'] = $user->nickname;
        $this->sessData['oauth'] = $user->oauth;
        $this->sessData['openid'] = $user->openid;
        $this->sessData['level'] = $user->level;
        $this->sessData['last_login'] = $user->last_login;
        $this->sessData['is_vip'] = $user->is_vip;
    }

    //微信注册
    public function WeixinRegister($data)
    {
        $this->sex = $data['sex'];
        $this->oauth = $data['oauth'];
        $this->openid = $data['openid'];
        $this->unionid = $data['unionid'];
        $this->head_pic = $data['head_pic'];
        $this->nickname = $data['nickname'];
        $this->level = 1;
        $this->status = 1;
        $this->is_vip = 0;
        $this->last_login = $this->create_at  = time();
        $this->last_ip = getClientIp();
        $this->save();
        $this->setsessData($this);
        return $this->sessData;
    }

    //微信注册
    public function WeixinLogin($data)
    {
        $map = array(
            'oauth'=>$data['oauth'],'openid' => $data['openid'],'status'=>1
        );
        $user = $this->where($map)->find();
        if(empty($user)) return array();
        $user->unionid = $data['unionid'];
        $user->nickname = $data['nickname'];
        $user->head_pic = $data['head_pic'];
        $user->last_login = time();
        $user->last_ip = getClientIp();
        $user->save();
        $this->setsessData($user);
        return $this->sessData;
    }

    //qq注册
    public function QqRegister($data)
    {
        $this->sex = $data['sex'];
        $this->oauth = $data['oauth'];
        $this->openid = $data['openid'];
        $this->unionid = '';
        $this->head_pic = $data['head_pic'];
        $this->nickname = $data['nickname'];
        $this->level = 1;
        $this->status = 1;
        $this->is_vip = 0;
        $this->last_login = $this->create_at  = time();
        $this->last_ip = getClientIp();
        $this->save();
        $this->setsessData($this);
        return $this->sessData;
    }

    public function QqLogin($data)
    {
        $map = array(
            'oauth'=>$data['oauth'],'openid' => $data['openid'],'status'=>1
        );
        $user = $this->where($map)->find();
        if(empty($user)) return array();
        $user->nickname = $data['nickname'];
        $user->head_pic = $data['head_pic'];
        $user->last_login = time();
        $user->last_ip = getClientIp();
        $user->save();
        $this->setsessData($user);
        return $this->sessData;
    }

    //阿里巴巴注册
    public function AlipayRegister($data)
    {

    }
}

<?php

namespace app\manage\model;

use think\Model;
use think\Session;
use think\Validate;

class Admin extends Model
{
    protected $rule=[
        'account'=>'require|/^1[34578]\d{9}$/',
        'password'=>'require',
//        'code'=>'require|captcha',
    ];
    protected $msg=[
        'account'=>'手机号格式错误！',
        'password'=>'密码不能为空！',
        'code.require'=>'验证码不能为空！',
        'code.captcha'=>'验证码错误！',
    ];
    public function login($post)
    {
        /* 验证 */
        $validate = new Validate($this->rule,$this->msg);
        if(!$validate->check($post)){
            $this->error = $validate->getError();
            return false;
        }
        $one = self::get(['mobile'=>$post['account']]);
        //dump($one);die;
        if (!empty($one)) {
            if ($this->_valid_password($one['password'],$post['password'],$one['salt'])) {
                unset($one['password']);
                unset($one['salt']);
                Session::set('user', $one);
                return true;
            }
        }
        $this->error = '用户名或密码不正确！';
        return false;
    }

    /**
     * 验证密码
     * @param string $encrypted
     * @param string $plain
     * @return bool
     */
    private function _valid_password($encrypted, $plain, $salt)
    {
        return $encrypted === md5(md5($plain) . $salt);
    }

    public function ceshi($post){
        $one = self::get(['mobile'=>$post]);
        return $one;
    }
}

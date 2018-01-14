<?php
namespace app\manage\controller;
use extend\Dingtalk\DingTalk;
class Index extends Admin
{
    public function index()
    {
        return $this->_tpl();
    }
    public function test()
    {
        $foo = new \Dingtalk\DingTalk();
//        $ceshi = $foo->get_all_users("18170783931");
        $ceshi = $foo->get_users_count();
        var_dump($ceshi);
    }
}
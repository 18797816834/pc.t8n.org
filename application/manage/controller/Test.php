<?php
namespace app\manage\controller;


use think\Controller;
use think\Request;

class Test extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->assign("name" ,"cyk");
        return $this->_tpl("test/index");
    }

    /**
     * @author cyk
     * 获取密码
     */
    public function test()
    {
        $plain = "a1234567";//密码
        $salt = "987g"; //随机字符串=== 密码加盐值
        var_dump(md5(md5($plain) . $salt));
        $request = Request::instance();
        $request->root('index.php');
        $l = $request->pathinfo('index/index/hello');
        $l = url("login/test");
        var_dump($l);
    }
    private function _valid_password($encrypted, $plain, $salt)
    {
        return $encrypted === md5(md5($plain) . $salt);
    }
}

<?php
namespace app\manage\controller;

use think\Controller;
use think\Request;
use think\Cache;
use think\Loader;
use think\Session;
use extend\Dingtalk\DingTalk;

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     * 登入页面
     */
    public function index(){
        if (Session::get('user')) {
            $this->redirect('manage/index/index');die;
        }
        return $this->fetch();
    }

    /**
     * @author cyk
     * @return mixed
     * 钉钉免登
     */
    public function ding_login(){
        $ding = new \Dingtalk\DingTalk();
        if ($_POST) {
            $user_id = $this->input->post('user_id');
            if ($user_id) {
                $this->session->set_userdata("ding_user_id", $user_id);
                $use_info = $this->Dingtalk_service->userGetInfo($user_id);
                $this->load->service("User_service");
                $amc_use_info = $this->User_service->get_user_by_mobile($use_info['mobile'])['data'];
                if (isset($amc_use_info['id'])) {
                    $this->session->set_userdata("user_id", $amc_use_info['id']);
                    showresult(url('login/ding_login'), 0);
                } else {
                    showresult(url('login/ding_login'), 0);
                }

            } else {
                showresult("您没有权限访问！", 1);
            }
        }
        $data['config'] = $ding->getConfig();
        $data['use_info'] = $use_info;
        $this->fetch("login/ding_login",$data);
    }

    //通过CODE换取用户身份
    public function get_login_info()
    {
        $ding = new \Dingtalk\DingTalk();
        $code = $this->input->post('code');
        if ($code) {
            $info = $ding->userGetUserInfo($code);
            if ($info['errcode']) {
                showresult($info, 1);
            } else {
                showresult($info, 0);
            }
        }
        showresult('fail: get login info', 1);
    }

    /**
     * @param Request $request
     * @return array
     * 登入验证
     */
    public function check_login(Request $request){
        $model = Loader::model('Admin');
        if ($model->login($request->param()))
            return showresult("登录成功",0);
        else
            return showresult($model->getError());
    }

    /**
     * 退出登入
     */
    public function logout(){
        Session::clear();
        $this->redirect('manage/login/index');
    }

}

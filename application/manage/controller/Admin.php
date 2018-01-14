<?php
namespace app\manage\controller;

use think\Controller;
use think\Loader;
use think\Request;
use think\model;
use think\Session;

class Admin extends Controller
{

    /**
     * @var string 布局名称
     */
    public $layout = "";
    /**
     * @var string 当前url
     */
    protected $_current_url = "";

    /**
     * 后台控制器模板公共渲染数据
     */
    public $view_data = array();
    
    public function __construct()
    {
        parent::__construct();
        if (!(Session::get('user'))) {
            $this->redirect('manage/login/index');die;
        }
        $request = Request::instance();
        $module =  $request->module();
        $controller = $request->controller();
        $action = $request->action();
        if($module != "manage"){
            abort(404,'请求非法！');
        }
        $url = "";
        if ($action == '' || $controller == '') {
            $url = "";
        }
        $url .= strtolower($controller . '/' . $action);  //当前访问的url_code

        $this->_current_url = $url;
        $this->view_data["menu_list"] = $this->get_menu_list($url);
    }

    private function get_menu_list($url){
        $model = Loader::model("Res");
        $menu = $model->get_list($url);
        return $menu;
    }

    /** 视图加载
     * @param $view
     * @param array $vars
     * @param bool $string
     * @return mixed
     */
    protected function _tpl($view = "", $vars = array(), $string = false)
    {
        return $this->view_load_tpl($view, $vars, $string);
    }

    /**
     * 加载tpl
     * @param $view
     * @param array $vars
     * @param bool|false $is_string
     * @return mixed
     * @throws Exception
     */
     private function view_load_tpl($view, $vars = array(), $is_string = false)
    {
        $vars = array_merge($vars, $this->view_data);
        if ($is_string) {
            return $vars;
        } else {
            return $this->fetch($view,$vars);
        }
    }
    
    public function index()
    {
        return 8888;
    }
    
}

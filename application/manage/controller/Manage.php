<?php
namespace app\manage\controller;
use think\Controller;
class Manage  extends  Controller
{
    public function index()
    {
//        echo "this's manage of module";
       return $this->fetch();
    }

}
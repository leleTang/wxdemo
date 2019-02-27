<?php
namespace app\index\controller;

use \think\View;

class Index
{
    //验证输入信息与页面显示
    public function index()
    {
        $view = new View();
        return $view->fetch();
    }
}

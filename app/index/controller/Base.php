<?php
/**
 * Created by PhpStorm.
 * User: zhongwu
 * Date: 2018/4/17
 * Time: 下午5:21
 */
namespace app\index\controller;
use think\Controller;
class Base extends Controller{
    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
    }

    public function checkLogin()
    {
        if(empty(session('user'))){
            $this->redirect('/index/login/index');
        }
    }
}
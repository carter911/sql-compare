<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    protected $_db1 = '';
    protected $_db2 = '';
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        return $this->fetch('index');
    }

    public function check_login(Request $request)
    {
        $param = $request->only('user_name,password');
        if(config('login_user') == $param['user_name'] &&
        config('login_password') == $param['password']){
            session('user',['user'=>$param['user_name']]);
            return ['code'=>200,'message'=>'登陆成功','data'=>''];
        }
        return ['code'=>'3001','message'=>'账号或者密码错误','data'=>''];

    }
    

}

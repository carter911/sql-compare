<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;

class Login extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->assign('login_url',url('login/check_login'));
        $this->assign('get_code',url('login/check_login'));
    }

    public function index()
    {
        return $this->fetch('index');
    }

    /**
     * 检查登陆
     * @param Request $request
     * @return string
     */
    public function check_login(Request $request)
    {
        $param = $request::instance()->param();
        try{
            $info = Db::name('User')->where(['username'=>$param['user_name']])->find();
            if(isset($info) && $info['password'] == md5($param['password'])){
                session('admin',$info);
                return die(json_encode(['code'=>200,'msg'=>'登陆成功','data'=>['url'=>url('index/index')]]));
            }else {
                return die(json_encode(['code'=>3001,'msg'=>'账号或者密码错误','data'=>['url'=>url('login/index')]]));
            }
        }catch (Exception $e){
            return die(json_encode(['code'=>5001,'msg'=>'账号或者密码错误','data'=>['url'=>url('login/index')]]));
        }
    }
}

<?php
namespace app\admin\controller;
use think\Db;

class Index extends Base
{
    public function index()
    {

        //$info = Db::name('admin_nav')->find();
        return $this->fetch('index',['name'=>'thinkphp']);
    }
}

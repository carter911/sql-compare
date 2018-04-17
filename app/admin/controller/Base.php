<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Base extends Controller
{
    protected $_rules = '';
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $admin = session('admin');
        $is_login = empty($admin)?0:1;
        $this->assign('is_login',$is_login);
        $this->check_login($admin);
        $this->get_menu($admin);
        $this->check_auth();
    }

    public function check_auth()
    {
        
    }

    public function check_login($admin)
    {

        if(empty($admin)){
            redirect("/admin/login/index");
            return false;
        }
    }

    public function get_menu($admin)
    {

        $rules = Db::name('auth_group_access')->alias('AuthGroupAccess')
            ->join('sgb_auth_group AuthGroup','AuthGroup.id = AuthGroupAccess.group_id')
            ->where('uid',$admin['id'])
            ->value('rules');
        $this->_rules = $rules;

        $menu = Db::name('auth_rule')
            ->alias('AuthRule')
            ->field('AdminNav.*')
            ->join('sgb_admin_nav AdminNav','AdminNav.mca = AuthRule.name')
            ->where(['AuthRule.id'=>['in',$rules]])
            ->order('pid asc')
            ->select();
        $format_menu = [];
        foreach ($menu as $key => $val){
            if($val['pid'] == 0){
                $format_menu[$val['id']] = $val;
            }else{
                $format_menu[$val['pid']]['children'][] = $val;
            }
        }
        $this->assign('system_menu',$format_menu);
        $this->assign('auth',$rules);
    }


}

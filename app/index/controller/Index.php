<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Index extends Base
{
    protected $_db1 = '';
    protected $_db2 = '';
    public function __construct()
    {
        parent::__construct();
        $this->_db1 = Db::connect(config('db1'));
        $this->_db2 = Db::connect(config('db2'));

    }
    public function index()
    {
        return $this->fetch('index');
    }

    public function table(Request $request)
    {

        $status = $request->param('status',0);

        $dev_table      = $this->_db1->query('show tables');
        $test_tables    = $this->_db2->query('show tables');

        $dev_table      = array_column($dev_table,"Tables_in_sgb_dev");
        $test_table      = array_column($test_tables,"Tables_in_sgb");

        //交集
        $intersect = array_intersect($dev_table,$test_table);
        //存在表一不存在表二
        $table1 = array_diff($dev_table,$test_table);
        //存在表二不存在表一
        $table2 = array_diff($test_table,$dev_table);

        $intersect  = is_array($intersect)?$intersect:array();
        $table1     = is_array($table1)?$table1:array();
        $table2     = is_array($table2)?$table2:array();
        switch ($status){
            case 1:
                $data = $intersect;break;
            case 2:
                $data = $table1;break;
            case 3:
                $data = $table2;break;
            default:
                $data = array_merge_recursive($intersect,$table1,$table2);break;
        }

        $source = [];
        foreach ($data as $key => $val){
            $source[$key]['name'] = $val;
            if(in_array($val,$intersect)){
                $source[$key]['status'] = 1;
            }else if(in_array($val,$table1)){
                $source[$key]['status'] = 2;
            }else if(in_array($val,$table2)){
                $source[$key]['status'] = 3;
            }
        }
        $this->assign('data',$source);
        return $this->fetch('table');
    }


    public function table_copy(Request $request)
    {
        $table = $request->param('table','sgb_user');
        $db = $request->param('db','db1');
        $db = $db == 'db1'?$this->_db1:$this->_db2;
        $view = $db->query("show create table `{$table}`");
        $view[0]['Create'] = $view[0]['Create Table'];
        $this->assign('info',$view[0]);
        return $this->fetch('table_copy');
    }

    public function table_view(Request $request)
    {
        $table = $request->param('table','sgb_user');
        $db = $request->param('db','db1');
        $db = $db == 'db1'?$this->_db1:$this->_db2;
        $view = $db->query("show create table `{$table}`");
        $info = $db->query("SHOW FULL COLUMNS FROM `{$table}`");
        $data_list[0]['field'] = $info;
        $data_list[0]['create'] = $view;
        $this->assign('data_list',$data_list);
        return $this->fetch('table_view');
    }

    public function table_diff(Request $request)
    {
        $table = $request->param('table','sgb_user');
        $view = $this->_db1->query("show create table `{$table}`");
        $info = $this->_db1->query("SHOW FULL COLUMNS FROM `{$table}`");
        $data_list[0]['field'] = $info;
        $data_list[0]['create'] = $view;
        $this->assign('data_list',$data_list);


        $view1 = $this->_db2->query("show create table `{$table}`");
        $info1 = $this->_db2->query("SHOW FULL COLUMNS FROM `{$table}`");
        $data_list1[0]['field'] = $info1;
        $data_list1[0]['create'] = $view1;

        $this->assign('data_list1',$data_list1);

        return $this->fetch('table_diff');
    }

    public function table_list(Request $request)
    {
        $db = $request->param('db','db1');
        $db = $db == 'db1'?$this->_db1:$this->_db2;
        $table_list   = $db->query('show tables');
        $data_list = [];
        foreach ($table_list as $key => $val){
            $table = array_values($val);
            $view = $db->query("show create table `{$table[0]}`");
            $info = $db->query("SHOW FULL COLUMNS FROM `{$table[0]}`");
            $data_list[$key]['field'] = $info;
            $data_list[$key]['create'] = $view;

        }
        $this->assign('data_list',$data_list);
        return $this->fetch('table_list');
    }
}

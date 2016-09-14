<?php
/**
 * Created by PhpStorm.
 * User: bailong
 * Date: 2016/8/26
 * Time: 11:47
 */

namespace Controller;

use Model\Factory;

class LoginController
{
    public $back;
    private $dbq;
    private $tpl;

    public function __construct()
    {
        session_start();

        Factory::CreateObj('connect');
        $this->dbq = Register::get('dbq');

        Factory::CreateObj('template');
        $this->tpl = Register::get('template');

        $this->tpl->show('reg');

        if (isset($_GET['name'])){
            $this->do_get_data($_GET);
        }
        if ($_POST){
            $this->do_post_data($_POST);
        }
    }

    public function do_post_data($p){
        //传递过来的数据
        $username = $p['uname'];
        $pwd = $p['pwd'];
        $re_pwd = $p['re_pwd'];
        $yzm = $p['yzm'];

        //后端验证
        if($pwd != $re_pwd) {
            $this->back = '密码不一致!';
            exit;
        }
        if ($yzm != json_decode($_SESSION['code'])) {
            $this->back = '验证码错误!';
            exit;
        }
        $data = array(
            'name' => $username,
            'pwd'  => $pwd,
        );
        //插入数据
        $reg_id = insert_into('user', $data);
        if (is_numeric($reg_id)){
            $this->back =  'ok';
        }else{
            $this->back =  '注册失败！';
        }
    }

    public function do_get_data($get){
        $name = strip_tags($get['name']);
        //用户名是否可用
        if (!$name) $this->back = 'no name';
        $names = self::find_name();
        if (!in_array($name, $names)){
            $this->back =  'can';
        }else{
            $this->back = 'cant';
        }
    }
    /**
     * 取出所有的用户名
     */
    private function find_name(){
        $sql = "SELECT name FROM user";
        $names = $this->dbq->query_all($sql);
        if (!$names) return false;
        foreach ($names as $k => $v){
            $name_arr[] = $v['name'];
        }
        return $name_arr;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/22
 * Time: 16:49
 */

namespace Model;


use Controller\Register;

class IndexModel
{
    private  $conn;

    public function __construct($param=null)
    {
        Factory::CreateObj('connect');
        $this->conn = Register::get('dbq');
    }

    /**
     * 首页方法
     * @return mixed
     */
    public function getindex($obj){
        $time1 = (int)$obj['time1'];
        $time2 = (int)$obj['time2'];
        $str = [];
        $str_str = '';
        if ($time1 && $time2) $str[] = " log_time BETWEEN $time1 AND $time2 ";
        if ($str) $str_str = 'WHERE' . implode('AND',$str);
        $sql = "SELECT * FROM log_do $str_str";
        $res = $this->conn->query_all($sql);
        return $res;
    }

    public function insert_log($obj){
        $data = ['log_time', 'log_title', 'log_data'];
        $value=[time(),'test1','test'];
        $this->conn->insert_into('log_do', $data, $value);
    }

    public function update_log($obj){
        $log_title=$obj['title'];
        $log_data=$obj['data'];
        $l_id = (int)$obj['id'];
        if (!$l_id || !$log_data || !$log_title) return FALSE;
        $sql = "UPDATE log_do SET log_title='{$log_title}',log_data='{$log_data}' WHERE l_id=$l_id";
        $this->conn->query($sql);
        return TRUE;
    }

}
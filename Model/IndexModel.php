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
    public function getindex(){
        $sql = "SELECT a.content,a.talk_time time,b.name FROM talklist a LEFT JOIN user b ON (a.user_id=b.id)";
        $res = $this->conn->query_all($sql);
        if (!$res) return false;
        foreach($res as $k => $v){
            $v['rand'] = rand(1,4);
            $v['time'] = date('Y年m月d日 H:i:s', $v['time']);
            $res[$k] = $v;
        }
        return $res;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/22
 * Time: 16:37
 */

namespace Controller;


use Model\Factory;
use Model\IndexModel;

class IndexController
{
    public $param;
    public $index;
    public $template;

    public function __construct()
    {
        //处理类
        $this->index = new IndexModel();
        //模版参数
        Factory::CreateObj('template');
        $this->template = Register::get('template');

        $this->param = $_REQUEST;
        $op = $this->param['op'];
        switch ($op){
            case 'upload':$this->upload();
                break;
            case 'insert':$this->insert();
                break;
            default:$this->index_list();
                break;
        }
    }

    public function insert(){
        $this->index->insert_log($this->param);
    }

    public function index_list(){
        $this->param['time1'] = strtotime($this->param['time1']);
        $this->param['time2'] = strtotime($this->param['time2']);
        $res = $this->index->getindex($this->param);
        if ($res){
            foreach($res as $k => $v){
                $v['date'] = date('Y-m-d H:i:s', $v['log_time']);
                $res[$k] = $v;
            }
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'Android'))
            $user_agent = 'mb';
        else
            $user_agent = 'pc';
        $this->template->assign('list', $res);
        $this->template->assign('user_agent', $user_agent);
        $this->template->show('index');
    }

    public function upload(){
        $this->index->update_log($this->param);
    }
}
<?php
/**
 * 配置文件
 * User: 95
 * Date: 2016/8/8
 * Time: 9:21
 */
define('S_ROOT', __DIR__);

$dbConfig['mysql'] = array(
    'dbhost'=>'localhost',
    'dbname'=> 'test',
    'dbuser'=> 'root',
    'dbpwd' => '',
    'db_prefix'=> '',
    'db_charset'=> 'utf8',
);
$Router = array(
    'default_controller' => 'home',//默认控制器
    'default_action' => 'index',//默认控制器
    'url_type' => 1,            //URL模式
);

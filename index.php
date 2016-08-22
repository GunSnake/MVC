<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/7
 * Time: 22:05
 */
require 'config.php';
include S_ROOT.'/Model/Loader.php';

spl_autoload_register("\\Model\\Loader::autoload");

\Controller\Register::set('request',\Controller\Router::request());
\Controller\Register::set('dbq',new \Model\Connection());
\Controller\Register::set('template', new \Lib\Template());

$request = \Controller\Register::get('request');
echo '<hr />'.'router'.'<br />';
var_dump($request);
if (!isset($request['do'])||$request['do'] == 'index'){
    $controller = new \Controller\IndexController();
}






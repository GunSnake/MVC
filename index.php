<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/7
 * Time: 22:05
 */
require 'config.php';
include_once S_ROOT.'/Model/Loader.php';

spl_autoload_register("\\Model\\Loader::autoload");
\Model\Factory::CreateObj('router');
$rout = \Controller\Register::get('router');

if (!isset($rout['do'])||$rout['do'] == 'index'){
    new \Controller\IndexController();
}else{
    switch ($rout['do']){
        case 'reg':
            $rback = new \Controller\LoginController();
            echo $rback->back;
            break;
        default:
            break;
    }
}


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

Model\Object::test();
App\Controller\Home\Home::test();
var_dump($GLOBALS);
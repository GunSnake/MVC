<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/23
 * Time: 10:48
 */

namespace Model;

use Controller\Register;
use Controller\Router;
use Lib\Template;

class Factory
{
    public static function CreateObj($name){
        switch ($name){
            case 'connect':
                $obj = Connection::getInstance();
                Register::set('dbq',$obj);
                break;
            case 'router':
                $obj = Router::request();
                Register::set('router',$obj);
                break;
            case 'template':
                $obj = Template::getInstance();
                Register::set('template',$obj);
                break;
        }
    }
}
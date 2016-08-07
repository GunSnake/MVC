<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/7
 * Time: 23:30
 */

namespace Model;


class Loader
{
    static function autoload($class){
        require S_ROOT .'/'. str_replace('\\', '/', $class).'.php';
    }
}
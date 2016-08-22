<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/22
 * Time: 9:58
 */

namespace Controller;

class Register{
    protected static $content;

    public static function set($key, $value){
        self::$content[$key] = $value;
    }

    public static function get($key){
        return self::$content[$key];
    }

    public static function _unset($key){
        unset(self::$content[$key]);
    }
}
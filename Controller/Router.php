<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/22
 * Time: 9:35
 */

namespace Controller;

class Router
{
    private static $request;
    public static $getParams=[];

    public static function request(){
        self::$request = $_SERVER['QUERY_STRING'];
        if (!self::$request) return self::$getParams;
        $params = explode('&', self::$request);
        foreach($params as $v){
            list($key, $value) = explode('=', $v);
            self::$getParams[$key] = $value;
        }
        return self::$getParams;
    }

    public static function method(){
        $scriptName = $_SERVER['SCRIPT_NAME'];
        preg_match('#\/([a-zA-Z0-9_]*).php#',$scriptName,$method);
        return $method[1];
    }
}
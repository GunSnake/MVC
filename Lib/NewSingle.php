<?php

/**
 * Created by PhpStorm.
 * User: bailong
 * Date: 2016/8/11
 * Time: 14:12
 */

/**
 * 懒汉式单例
 * Class NewSingle
 */
class NewSingle
{
    static $instance;
    public $dd;

    private function __construct(){
        $this->dd = '213';
    }

    public static function  getInstance(){
        if (!(self::$instance instanceof self)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone(){

    }
}

$single = NewSingle::getInstance();
echo $single->dd;

/**
 * php中饿汉模式无法使用
 * Class NewSingle2
 */
/*class NewSingle2{
    private static $instance = new self();
    public $dd = 22;

    private function __construct(){

    }

    public static function getInstance(){
        return self::$instance;
    }
}

$single2 = NewSingle2::getInstance();
echo $single2->dd;*/


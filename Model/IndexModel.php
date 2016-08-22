<?php
/**
 * Created by PhpStorm.
 * User: bailong
 * Date: 2016/8/22
 * Time: 16:49
 */

namespace Model;


class IndexModel
{
    public function __construct()
    {
        echo '<hr />'.'db'.'<br />';
        $dbq = \Controller\Register::get('dbq');
        $res = $dbq->query_one('select * from goods');
        var_dump($res);
    }
}
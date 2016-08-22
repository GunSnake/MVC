<?php
/**
 * Created by PhpStorm.
 * User: bailong
 * Date: 2016/8/22
 * Time: 16:37
 */

namespace Controller;


use Model\IndexModel;

class IndexController
{
    public function __construct()
    {
        echo '<hr />'.'模版'.'<br />';
        $tpl = \Controller\Register::get('template');
        $tpl->assign('data', '123');
        $tpl->assign('person', 'me');
        $tpl->assign('pai', 3.14);
        $arr = array(1,2,3,4,'123',4);
        $tpl->assign('b', $arr);
        $tpl->show('member');

        $index_model = new IndexModel();
    }
}
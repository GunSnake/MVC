<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/22
 * Time: 16:37
 */

namespace Controller;


use Model\Factory;
use Model\IndexModel;

class IndexController
{
    public function __construct()
    {
        $index_model = new IndexModel();
        $list = $index_model->getindex();
        $str = "{\$v['ccc']}";
        /*$str = preg_replace('#\{(\\$\S*)\}#', '<?php echo ${1};?>', $str);
        var_dump($str);die;*/
        Factory::CreateObj('template');
        $tpl = Register::get('template');
        $tpl->assign('list', $list);
        $tpl->show('index');
    }
}
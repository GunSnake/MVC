<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/15
 * Time: 20:37
 */

$app_id = 'wx9fdf8e1ef1f957d5';
$AppSecret = '53517134ef20dbc6a4a1e5a755218bfc';
$access_token = '52ZGecboPCSP2IeBW2REqmUwFT1cW5aBjlhjWtlZIOQjuzuKUKwGBaz-gtekimgxHgIoBckUMrChbLXxFyasc7AeXNNrkuTdCTLeddDieKIwfhLOUfv3KD8cSfx-pWOdBZAbAEAXVW';

include 'WeiXin/WeiXin.php';

$weixin = new \MVC\WeiXin\WeiXin($_GET, $app_id, $AppSecret);


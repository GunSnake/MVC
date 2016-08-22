<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/8/15
 * Time: 20:45
 */

namespace MVC\WeiXin;


class WeiXin
{
    private $get_str;
    private $access_token;
    private $appid;
    private $appsec;

    public function __construct($get, $appid, $appsec){
        $this->get_str = $get;
        $this->appid = $appid;
        $this->appsec = $appsec;
        $this->checkSihnature($this->get_str);
        //$this->getAccessToken();
    }

    /**
     * 获取access_token
     * @return mixed
     */
    private function getAccessToken(){
        if ( !$this->access_token || isset($this->access_token['errcode']) || ($this->access_token['expires_in']+$this->access_token['time'])<=time()){
            $this->access_token = json_decode(file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsec}"), true);
            $this->access_token['time'] = time();
        }else{
            return $this->access_token;
        }
    }

    /**
     * 模板消息，订阅号无权限
     */
    private function set_industry_id(){
        $industry_info = json_decode(file_get_contents("https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token={$this->access_token['access_token']}"), true);
    }

    /**
     * 自定义菜单，订阅号无权限
     */
    private function setDefaultMenu(){
        $myMenu = json_decode(file_get_contents("https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token={$this->access_token['access_token']}"), true);
        if (!isset($myMenu['selfmenu_info']) || $myMenu['is_menu_open'] == 0){
            $arr['is_menu_open'] = 1;
            $arr['selfmenu_info']['button'][] = ['type'=>'click','name'=>'按钮1','key'=>'do_click'];
            $arr['selfmenu_info']['button'][] = ['name'=>'按钮2','sub_button'=>[['type'=>'click','name'=>'按钮4','key'=>'do_click'],['type'=>'click','name'=>'按钮5','key'=>'do_click']]];
            $arr['selfmenu_info']['button'][] = ['type'=>'click','name'=>'按钮3','key'=>'do_click2'];
            $data = json_encode($arr);
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$this->access_token['access_token']}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
    }

    /**
     * 接口检测及发送消息
     */
    private function checkSihnature(){
        $signature = $this->get_str["signature"];
        $timestamp = $this->get_str["timestamp"];
        $nonce     = $this->get_str["nonce"];
        $echostr   = $this->get_str['echostr'];
        $token     = 'zxqc';

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature && $echostr){
            echo $echostr;
        }else{
            $this->responseMsg();
        }
    }

    /**
     * 发送消息
     */
    public function responseMsg(){
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string($postArr);
        if( strtolower($postObj->MsgType) == 'event' ){
            if( strtolower($postObj->Event) == 'subscribe' ){
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();
                $msgType = 'text';
                $content = '欢饮关注本公众账号,/n'.'用户账号：'.$postObj->FromUserName.'/n微信号'.$postObj->ToUserName;

                $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                    </xml>";
                $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
            }
        }elseif (strtolower($postObj->MsgType) == 'text'){
            $toUser = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $ucontent = $postObj->Content;
            $time = time();
            if ($ucontent == 'pictext'){
                $msg_type = 'news';
                $articlecount = 1;
                $title = '这是我的网站';
                $description = '俺来客';
                $pic_url = 'http://www.anlike.cc/public/images/1.png';
                $url = 'http://www.anlike.cc';
                /*欢饮关注本公众账号,/n用户账号：oBi7-swvm8a2-eFRj62zCKGMO5LQ/n微信号gh_aeecb740804d */
                $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>%s</ArticleCount>
                            <Articles>
                            <item>
                            <Title><![CDATA[%s]]></Title> 
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>
                            </Articles>
                            </xml>";
                $info = sprintf($template, $toUser, $fromUser, $time, $msg_type, $articlecount, $title, $description, $pic_url, $url);
            }elseif($ucontent == 'money'){
                $msgType = 'image';
                $mediaid = 123;
                $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                            </Image>
                            </xml>";
                $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $mediaid);
            }elseif(strpos($ucontent, '天气')){
                $city = explode(' ', $ucontent);
                $weather_api = '3ee80c47499e4cb0629be5ab5ce6020b';
                $ch = curl_init();
                $url = 'http://apis.baidu.com/heweather/weather/free?city='.$city[0];
                $header = array(
                    'apikey: '.$weather_api,
                );
                // 添加apikey到header
                curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // 执行HTTP请求
                curl_setopt($ch , CURLOPT_URL , $url);
                $res = curl_exec($ch);
                $res = json_decode($res, true);
                if(!isset($res['errNum'])){
                    foreach($res as $v){
                        foreach($v as $vv){
                            $data['updatetime'] = $vv['basic']['update']['loc'];
                            if (isset($vv['alarms'])){
                                $data['warning'] = $vv['type'].$vv['level'].$vv['stat'].'\n'.$vv['txt'];
                            }
                            foreach ($vv['now'] as $kkk => $vvv){
                                switch ($kkk){
                                    case 'tmp': $data['now'][1] = '当前温度:'.$vvv.'℃';break;
                                    case 'fl':$data['now'][2] = '体感温度:'.$vvv.'℃';break;
                                    case 'wind':$data['now'][3] = '风力状况:'.$vvv['dir'].' '.$vvv['sc'].'级';break;
                                    case 'cond':$data['now'][0] = '天气:'.$vvv['txt'];break;
                                    case 'pcpn':$data['now'][5] = '降雨量(mm):'.$vvv;break;
                                    case 'hum':$data['now'][4] = '湿度(%):'.$vvv;break;
                                    case 'pres':$data['now'][6] = '气压:'.$vvv;break;
                                    case 'vis':$data['now'][7] = '能见度(km):'.$vvv;break;
                                }
                            }
                            ksort($data['now']);
                            foreach ($vv['aqi']['city'] as $kkk => $vvv){
                                switch ($kkk){
                                    case 'aqi': $data['aqi'][1] = '空气质量指数:'.$vvv;break;
                                    //case 'co':$data['aqi'][] = '一氧化碳1小时平均值:'.$vvv;break;
                                    //case 'no2':$data['aqi'][] = '二氧化氮1小时平均值:'.$vvv;break;
                                    case 'o3':$data['aqi'][4] = '臭氧1小时平均值:'.$vvv;break;
                                    case 'pm10':$data['aqi'][3] = 'PM10 1小时平均值:'.$vvv;break;
                                    case 'pm2.5':$data['aqi'][2] = 'PM2.5 1小时平均值:'.$vvv;break;
                                    case 'qlty':$data['aqi'][0] = '空气质量:'.$vvv;break;
                                    case 'so2':$data['aqi'][5] = '二氧化硫1小时平均值:'.$vvv;break;
                                }
                            }
                            ksort($data['aqi']);
                        }
                    }
                    foreach ($data as $v){
                        $content .= implode("\r\n", $v) . "\r\n";
                    }
                }else{
                    $content = '没有查到相关的数据';
                }
                $msgType = 'text';
                $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                    </xml>";
                $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
            }else{
                $msgType = 'text';
                $content = 'this is ' . $postObj->Content;
                $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                    </xml>";
                $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
            }
            echo $info;
        }
    }
}
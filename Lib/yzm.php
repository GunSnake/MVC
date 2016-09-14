<?php
/** 验证码生成程序 */
session_start();
header("content-type: image/png;charset=UTF-8;");

$width = 120;
$height = 35;
#字体大小
$size = 15;
#字体样式
$font = '../public/fonts/MSYH.TTF';
#设置汉字显示字数
$show_num = 9;
#获得随机得到的unicode汉字码
$code_all = $code = get_unicode($show_num);
#匹配不同四个字
for ($i=0;$i<4;$i++){
	$rand = mt_rand(0, $show_num-1);
	$verifycode_arr[] = $code[$rand];
	unset($code[$rand]);
	$code = array_merge($code);
	$show_num--;
}
$_SESSION['base_code'] = json_encode(implode($code_all, ''));
$verifycode = implode($verifycode_arr, ' ');
$_SESSION['code'] = json_encode(implode($verifycode_arr, ''));
#创建图片
$im = imagecreatetruecolor($width, $height);
#色彩定义
$black = imagecolorallocate($im, 0, 0, 0);
$white = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$blue = imagecolorallocate($im, 0, 0, 255);
$green = imagecolorallocate($im, 0, 255, 0);
#图片填充白色
imagefill($im, 0, 0, $white);
#文字写入图片
imagettftext($im, $size, 0, 10, 25, $black, $font, $verifycode);
for($i=0;$i<50;$i++)  //加入干扰象素
{
	imagesetpixel($im, rand(0, $width), rand(0, $height), $black);    //加入点状干扰素
	imagesetpixel($im,  rand(0, $width), rand(0, $height), $red);
	imagesetpixel($im,  rand(0, $width), rand(0, $height), $green);
	//imagearc($im, rand(0, $width), rand(0, $height), 20, 20, 75, 170, $black);    //加入弧线状干扰素
	//imageline($im, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $red);    //加入线条状干扰素
}
imagepng($im);
imagedestroy($im);
/**
 * 
 * @param unknown $num_hz
 */
function get_unicode($num_hz){
	#文件名
	$filename = '../public/unicode.txt';

	#文件大小
	$size = filesize($filename);
	#取出文件中数据
	$file = fopen($filename, 'r');
	$content = fread($file, $size);
	fclose($file);
	#去空行
	$qian=array(" ","　","\t","\n","\r");
	$hou=array("","","","","");
	$code_all = str_replace($qian,$hou,$content);
	$str_len = mb_strlen($code_all, 'UTF-8') - 1;
	#分解为数组
	for ($i=0;$i<$str_len-1;$i++){
		$code_arr[] = mb_substr($code_all, $i, 1, 'UTF-8');
	}
	unset($code_all);
	#随机挑出$num_hz个汉字
	$num = count($code_arr) - 1;
	for ($i=0;$i<$num_hz;$i++){
		$rand = mt_rand(1, $num);
		$code[] = $code_arr[$rand];
	}
	unset($code_arr);
	return $code;
}
?>
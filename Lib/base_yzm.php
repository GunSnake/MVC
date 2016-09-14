<?php
/** 所有的验证码字符 */
session_start();
header("content-type: image/png;charset=UTF-8;");
$width = 180;
$height = 180;
#字体大小
$size = 20;
#字体样式
$font = '../public/fonts/MSYH.TTF';
$base_code = json_decode($_SESSION['base_code'], true);
#分解为数组
for ($i=0;$i<9;$i++){
	$code_all[] = mb_substr($base_code, $i, 1, 'UTF-8');
}
#划分三个为一个数组
$i = 0;
foreach ($code_all as $k => $v){
		if (fmod($k, 3) == 0){
			$i++;
		}
		$code_arr[$i-1][] = $v;
}
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
$pos = (($width / 3) - $size)/2;
#文字定位
for ($j=0;$j<3;$j++){
	imagettftext($im, $size, 0, $pos + ($width/3)*0, $pos*2 + ($width/3)*$j, $black, $font, $code_arr[$j][0]);
	imagettftext($im, $size, 0, $pos + ($width/3)*1, $pos*2 + ($width/3)*$j, $black, $font, $code_arr[$j][1]);
	imagettftext($im, $size, 0, $pos + ($width/3)*2, $pos*2 + ($width/3)*$j, $black, $font, $code_arr[$j][2]);
}
//加上边框
imageline($im, 0, 0, 0, 179, $black);
imageline($im, 0, 0, 179, 0, $black);
imageline($im, 179, 179, 0, 179, $black);
imageline($im, 179, 179, 179, 0, $black);
//分割汉字
imageline($im, 0, $height/3, $width, $height/3, $red);
imageline($im, 0, ($height*2)/3, $width, ($height*2)/3, $red);
imageline($im, $width/3, 0, $width/3, $height, $red);
imageline($im, ($width*2)/3, 0, ($width*2)/3, $height, $red);

/* for($i=0;$i<50;$i++)  //加入干扰象素
{
	imagesetpixel($im, rand(0, $width), rand(0, $height), $black);    //加入点状干扰素
	imagesetpixel($im,  rand(0, $width), rand(0, $height), $red);
	imagesetpixel($im,  rand(0, $width), rand(0, $height), $green);
	//imagearc($im, rand(0, $width), rand(0, $height), 20, 20, 75, 170, $black);    //加入弧线状干扰素
	//imageline($im, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $red);    //加入线条状干扰素
} */
imagepng($im);
imagedestroy($im);
<?php

//1.创建画布
$width = 500;
$height = 300;
$image = imagecreatetruecolor($width,$height);

//2.创建颜色
$color = imagecolorallocate($image,255,255,255);

//3.填充画布
imagefilledrectangle($image,0,0,500,300,$color);

//4.开始绘画
$randColor = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
imagettftext($image,20,0,230,150,$randColor,'C:/Windows/Fonts/Dengb.ttf','宁波');

//5.浏览器输出图片格式
header('content-type:image/png');

//6.浏览器输出图片
imagepng($image);
//imagepng($image,'images/gd2_test.png');

//7.销毁资源
imagedestroy($image);
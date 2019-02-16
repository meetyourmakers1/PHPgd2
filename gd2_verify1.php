<?php

//1.创建画布
$width = 500;
$height = 300;
$image = imagecreatetruecolor($width,$height);

//2.创建颜色
$color = imagecolorallocate($image,255,255,255);

//3.填充画布
imagefilledrectangle($image,0,0,500,300,$color);

//3.画笔颜色
$randColor = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));

//4.开始绘画
$size = 20;
$angle = mt_rand(-45,45);
$x = 230;
$y = 150;
$font = 'C:/Windows/Fonts/Dengb.ttf';
$text = mt_rand(1000,9999);
imagettftext($image,$size,$angle,$x,$y,$randColor,$font,$text);

//5.浏览器输出图片格式
header('content-type:image/jpeg');

//6.浏览器输出图片
imagepng($image);

//7.销毁资源
imagedestroy($image);
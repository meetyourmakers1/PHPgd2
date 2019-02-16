<?php

//1.创建画布
$width = 500;
$height = 300;
$image = imagecreatetruecolor($width,$height);

//2.创建颜色
$color = imagecolorallocate($image,0,255,0);

//3.开始绘画

//水平方向
imagechar($image,5,250,130,'X',$color);
//垂直方向
imagecharup($image,5,250,180,'Y',$color);

imagestring($image,5,250,150,'ningbo',$color);

//4.浏览器输出图片格式
header('content-type:image/jpeg');

//5.浏览器输出图片
imagejpeg($image);

//6.销毁资源
imagedestroy($image);
<?php

//1.创建画布
$width = 500;
$height = 300;
$image = imagecreatetruecolor($width,$height);

//2.创建颜色
$color = imagecolorallocate($image,255,255,255);

//3.填充画布
imagefilledrectangle($image,0,0,$width,$height,$color);

//3.画笔颜色
function randColor($image){
    return imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
}

$string = join('',array_merge(range(0,9),range('a','z'),range('A','Z')));

//4.开始绘画
$textWidth = imagefontwidth(20);
$textHeight = imagefontheight(20);
$length = 4;
for($i=0;$i<$length;$i++){
    $size = 20;
    $angle = mt_rand(-45,45);
    $x = ($width-$textWidth*$length)/($length+1)+(($width-$textWidth*$length)/($length+1))*$i;
    $y = mt_rand($height/3,$height*2/3);
    $randColor = randColor($image);
    $font = 'C:/Windows/Fonts/Dengb.ttf';
    $text = str_shuffle($string)[0];
    imagettftext($image,$size,$angle,$x,$y,$randColor,$font,$text);
}

//5.创建干扰元素
/*像素*/
for($i=0;$i<1000;$i++){
    imagesetpixel($image,mt_rand(0,$width),mt_rand(0,$height),randColor($image));
}
/*线段*/
for($i=0;$i<10;$i++){
    imageline($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),randColor($image));
}
/*圆弧*/
for($i=0;$i<10;$i++){
    imagearc($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width/2),mt_rand(0,$height/2),mt_rand(0,360),mt_rand(0,360),randColor($image));
}

//6.浏览器输出图片格式
header('content-type:image/jpeg');

//7.浏览器输出图片
imagepng($image);

//8.销毁资源
imagedestroy($image);
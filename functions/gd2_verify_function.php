<?php

function getVerify($width = 500,$height = 300,$type = 1,$length = 4,$pixel = 1000,$line = 10,$arc = 10,$font = 'C:/Windows/Fonts/Dengb.ttf'){
    //1.创建画布
    $image = imagecreatetruecolor($width,$height);

    //2.创建颜色
    $color = imagecolorallocate($image,255,255,255);

    //3.填充画布
    imagefilledrectangle($image,0,0,$width,$height,$color);

    //3.画笔颜色
    function randColor($image){
        return imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    }

    switch($type){
        case 1: //数字
            $string = join('',array_rand(range(0,9),$length));
            break;
        case 2: //字母
            $string = join('',array_rand(array_flip(array_merge(range('a','z'),range('A','Z'))),$length));
            break;
        case 3: //数字+字母
            $string = join('',array_rand(array_flip(array_merge(range(0,9),range('a','z'),range('A','Z'))),$length));
            break;
        case 4: //中文
            $str = '中,华,人,民,共,和,国';
            $string = join('',array_rand(array_flip(explode(',',$str)),$length));
            break;
        default:
            exit('非法参数');
            break;
    }

    session_start();
    $_SESSION['verify'] = $string;

    //4.开始绘画
    $textWidth = imagefontwidth(20);
    $textHeight = imagefontheight(20);

    for($i=0;$i<$length;$i++){
        $size = 40;
        $angle = mt_rand(-45,45);
        $x = ceil(($width-$textWidth*$length)/($length+1))+ceil(($width-$textWidth*$length)/($length+1))*$i;
        $y = mt_rand(ceil($height/3),ceil($height*2/3));
        $randColor = randColor($image);
        $text = mb_substr($string,$i,1,'utf-8');
        imagettftext($image,$size,$angle,$x,$y,$randColor,$font,$text);
    }

    //5.创建干扰元素
    /*像素*/
    if($pixel > 0){
        for($i=0;$i<$pixel;$i++){
            imagesetpixel($image,mt_rand(0,$width),mt_rand(0,$height),randColor($image));
        }
    }
    /*线段*/
    if($line > 0){
        for($i=0;$i<$line;$i++){
            imageline($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),randColor($image));
        }
    }
    /*圆弧*/
    if($arc > 0){
        for($i=0;$i<$arc;$i++){
            imagearc($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width/2),mt_rand(0,$height/2),mt_rand(0,360),mt_rand(0,360),randColor($image));
        }
    }

    //6.浏览器输出图片格式
        header('content-type:image/png');

    //7.浏览器输出图片
        imagepng($image);

    //8.销毁资源
        imagedestroy($image);
}

getVerify();
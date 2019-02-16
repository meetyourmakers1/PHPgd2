<?php

function getImageInfo($filename){
    $info = getimagesize($filename);
    $fileinfo['width'] = $info[0];
    $fileinfo['height'] = $info[1];

    $imagecreatefrom = str_replace('/','createfrom',$info['mime']);
    $image = str_replace('/',null,$info['mime']);

    $fileinfo['imagecreatefrom'] = $imagecreatefrom;
    $fileinfo['image'] = $image;
    $fileinfo['extension'] = strtolower(image_type_to_extension($info[2]));

    return $fileinfo;
}

function  imageWater($filename,$destination = '../images/water',$prefix = 'image_water',$fontfile = 'C:/Windows/Fonts/Dengb.ttf',$fontsize = 20,$angle = 0,$x = 100,$y = 100,$r = 255,$g = 255,$b = 255,$alpha = 50,$text = '图片水印',$deleteSource = false){
    $fileinfo = getImageInfo($filename);

    $src_image = $fileinfo['imagecreatefrom']($filename);

    $lightgray = imagecolorallocatealpha($src_image,$r,$g,$b,$alpha);

    imagettftext($src_image,$fontsize,$angle,$x,$y,$lightgray,$fontfile,$text);

    if($destination && !file_exists($destination)){
        mkdir($destination,0777,true);
    }

    $rand_name = mt_rand(10000,99999);
    $dst_name = "{$prefix}{$rand_name}".$fileinfo['extension'];
    $path = $destination?$destination.'/'.$dst_name:$destination;

    $fileinfo['image']($src_image,$path);

    imagedestroy($src_image);

    if($deleteSource){
        @unlink($filename);
    }

    return $path;
}

$filename = '../images/image.jpg';
echo imageWater($filename);
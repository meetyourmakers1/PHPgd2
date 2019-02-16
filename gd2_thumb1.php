<?php

$filename = 'images/image.jpg';

$fileinfo = getimagesize($filename);

list($src_w,$src_h) = $fileinfo;
$imagecreatefrom = str_replace('/','createfrom',$fileinfo['mime']);
$image = str_replace('/',null,$fileinfo['mime']);

$dst_w = 50;
$dst_h = 50;

$ratio_orig = $src_w / $src_h;
if($dst_w / $dst_h > $ratio_orig){
    $dst_w = $dst_h * $ratio_orig;
}else{
    $dst_h = $dst_w / $ratio_orig;
}

$dst_image = imagecreatetruecolor($dst_w,$dst_h);

$src_image = $imagecreatefrom($filename);

imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);

$image($dst_image,'images/image_ratio2.jpg');

imagedestroy($dst_image);

imagedestroy($src_image);


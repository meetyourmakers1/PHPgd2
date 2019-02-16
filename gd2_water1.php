<?php

$filename = 'images/image.jpg';
$fileinfo = getimagesize($filename);

$imagecreatefrom = str_replace('/','createfrom',$fileinfo['mime']);

$image = str_replace('/',null,$fileinfo['mime']);

$src_image = $imagecreatefrom($filename);

$lightgray = imagecolorallocatealpha($src_image,0,0,0,50);

$fontfile = 'C:/Windows/Fonts/Dengb.ttf';

imagettftext($src_image,20,0,100,100,$lightgray,$fontfile,'图片水印');

header('content-type:image/jpeg');

$image($src_image);

imagedestroy($src_image);
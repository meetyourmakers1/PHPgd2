<?php

$logo = 'images/logo.png';

$filename = 'images/image.jpg';

$dst_image = imagecreatefromjpeg($filename);

$src_image = imagecreatefrompng($logo);

imagecopymerge($dst_image,$src_image,0,0,0,0,200,80,25);

header('content-type:image/jpeg');

imagejpeg($dst_image);

imagedestroy($src_image);

imagedestroy($dst_image);
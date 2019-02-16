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

function imageWater($dst_name,$src_name,$position=0,$pct=50,$destination='../images/water',$prefix = 'image_water',$deleteSource = false){
    $dst_image_info = getImageInfo($dst_name);
    $src_image_info = getImageInfo($src_name);

    $dst_image = $dst_image_info['imagecreatefrom']($dst_name);
    $src_image = $src_image_info['imagecreatefrom']($src_name);

    $dst_width = $dst_image_info['width'];
    $dst_height = $dst_image_info['height'];

    $src_width = $src_image_info['width'];
    $src_height = $src_image_info['height'];

    switch ($position){
        case 0:
            $x = 0;
            $y = 0;
            break;
        case 1:
            $x = ($dst_width - $src_width) / 2;
            $y = 0;
            break;
        case 2:
            $x = $dst_width - $src_width;
            $y = 0;
            break;
        case 3:
            $x = 0;
            $y = ($dst_height - $src_height) /2;
            break;
        case 4:
            $x = ($dst_width - $src_width) / 2;
            $y = ($dst_height - $src_height) / 2;
            break;
        case 5:
            $x = $dst_width - $src_width;
            $y = ($dst_height - $src_height) / 2;
            break;
        case 6:
            $x = 0;
            $y = $dst_height - $src_height;
            break;
        case 7:
            $x = ($dst_width - $src_width) / 2;
            $y = $dst_height - $src_height;
            break;
        case 8:
            $x = $dst_width - $src_width;
            $y = $dst_height - $src_height;
            break;
        default:
            $x = 0;
            $y = 0;
            break;
    }

    imagecopymerge($dst_image,$src_image,$x,$y,0,0,$src_width,$src_height,$pct);

    if($destination && !file_exists($destination)){
        mkdir($destination,0777,true);
    }

    $rand_name = mt_rand(10000,99999);
    $dst_name = "{$prefix}{$rand_name}".$dst_image_info['extension'];
    $path = $destination?$destination.'/'.$dst_name:$destination;

    header('content-type:image/jpeg');

    //$dst_image_info['image']($dst_image,$path);
    $dst_image_info['image']($dst_image);

    imagedestroy($dst_image);
    imagedestroy($src_image);

    if($deleteSource){
        @unlink($src_name);
    }

    return $path;
}

$dst_name =  '../images/image.jpg';
$src_name = '../images/logo.png';

imageWater($dst_name,$src_name);
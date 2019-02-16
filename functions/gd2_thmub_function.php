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

function imageThumb($filename,$destination = '../images/thumb',$prefix = 'image_thumb_',$scale = 0.5,$dst_w = null,$dst_h = null,$deleteSource = false){
    $fileinfo = getImageInfo($filename);

    $src_w = $fileinfo['width'];
    $src_h = $fileinfo['height'];

    if(is_numeric($dst_w) && is_numeric($dst_h)){
        $ratio_orig = $src_w / $src_h;
        if($dst_w / $dst_h > $ratio_orig){
            $dst_w = $dst_h * $ratio_orig;
        }else{
            $dst_h = $dst_w / $ratio_orig;
        }
    }else{
        $dst_w = ceil($src_w*$scale);
        $dst_h = ceil($src_h*$scale);
    }

    $dst_image = imagecreatetruecolor($dst_w,$dst_h);
    $src_image = $fileinfo['imagecreatefrom']($filename);

    imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);

    if($destination && !file_exists($destination)){
        mkdir($destination,0777,true);
    }

    $rand_name = mt_rand(10000,99999);
    $dst_name = "{$prefix}{$rand_name}".$fileinfo['extension'];
    $path = $destination?$destination.'/'.$dst_name:$dst_name;

    $fileinfo['image']($dst_image,$path);

    imagedestroy($dst_image);

    imagedestroy($src_image);

    if($deleteSource){
        @unlink($filename);
    }

    return $path;
}

$filename = '../images/image.jpg';
echo imageThumb($filename);
<?php

class verify{

    private $_image = null;
    private $_width = 500;
    private $_height = 300;
    private $_size = 40;
    private $_type = 1;
    private  $_length = 4;
    private $_snow = 1000;
    private $_line = 10;
    private $_arc = 10;
    private $_fontfile = 'C:/Windows/Fonts/Dengb.ttf';

    public function __construct($config = [])
    {
        /*if(is_array($config) && count($config) > 0){*/
            //检测画布宽高
            if(isset($config['width']) && $config['width'] > 0){
                $this->_width = (int)$config['width'];
            }
            if(isset($config['height']) && $config['height'] > 0){
                $this->_height = (int)$config['height'];
            }
            if(isset($config['size']) && $config['size'] > 0){
                $this->_size = (int)$config['size'];
            }
            //检测验证码类型
            if(isset($config['type']) && $config['type'] > 0){
                $this->_type = (int)$config['type'];
            }
            //检测验证码长度
            if(isset($config['length']) && $config['length'] > 0){
                $this->_length = (int)$config['length'];
            }
            //检测干扰元素
            if(isset($config['snow']) && $config['snow'] > 0){
                $this->_snow = (int)$config['snow'];
            }
            if(isset($config['line']) && $config['line'] > 0){
                $this->_line = (int)$config['line'];
            }
            if(isset($config['arc']) && $config['arc'] > 0){
                $this->_arc = (int)$config['arc'];
            }
            //检测字体文件
            if(isset($config['fontfile']) && is_file($config['fontfile']) && is_readable($config['fontfile'])){
                $this->_fontfile = $config['fontfile'];
            }
            //1.创建画布
            $this->_image = imagecreatetruecolor($this->_width,$this->_height);
            return $this->_image;
        /*}else{
            return false;
        }*/
    }

    public function getVerify(){
        //2.创建颜色
        $color = imagecolorallocate($this->_image,255,255,255);
        //3.填充画布
        imagefilledrectangle($this->_image,0,0,$this->_width,$this->_height,$color);
        //4.验证码字符串
        $string = join('',array_rand(array_flip(array_merge(range(0,9),range('a','z'),range('A','Z'))),$this->_length));
        //5.开始绘画
        for($i=0;$i<$this->_length;$i++){
            $angle = mt_rand(-45,45);
            $textWidth = imagefontwidth($this->_size);
            $x = ceil(($this->_width-$textWidth*$this->_length)/($this->_length+1))+ceil(($this->_width-$textWidth*$this->_length)/($this->_length+1))*$i;
            $y = mt_rand(ceil($this->_height/3),ceil($this->_height*2/3));
            $randColor = $this->_randColor($this->_image);
            $text = mb_substr($string,$i,1,'utf-8');
            imagettftext($this->_image,$this->_size,$angle,$x,$y,$randColor,$this->_fontfile,$text);
        }
        //6.创建干扰元素
        /*像素*/
        if($this->_snow > 0){
            for($i=0;$i<$this->_snow;$i++){
                imagestring($this->_image,mt_rand(0,$this->_size),mt_rand(0,$this->_width),mt_rand(0,$this->_height),'x',$this->_randColor($this->_image));
            }
        }
        /*线段*/
        if($this->_line > 0){
            for($i=0;$i<$this->_line;$i++){
                imageline($this->_image,mt_rand(0,$this->_width),mt_rand(0,$this->_height),mt_rand(0,$this->_width),mt_rand(0,$this->_height),$this->_randColor($this->_image));
            }
        }
        /*圆弧*/
        if($this->_arc > 0){
            for($i=0;$i<$this->_arc;$i++){
                imagearc($this->_image,mt_rand(0,$this->_width),mt_rand(0,$this->_height),mt_rand(0,$this->_width/2),mt_rand(0,$this->_height/2),mt_rand(0,360),mt_rand(0,360),$this->_randColor($this->_image));
            }
        }
        //7.浏览器输出图片格式
        header('content-type:image/png');

        //8.浏览器输出图片
        imagepng($this->_image);

        //9.销毁资源
        imagedestroy($this->_image);
    }

    /*画笔颜色*/
    private function _randColor($image){
        return imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    }
}
$verify = new verify();
$verify->getVerify();
<?php

//echo phpinfo();

//检测扩展是否开启
var_dump(extension_loaded('gd'));

//检测函数是否可用
var_dump(function_exists('gd_info'));

//获取gd2库信息
var_dump(gd_info());

//获取所有已定义的函数
print_r(get_defined_functions());
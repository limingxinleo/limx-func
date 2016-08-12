<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/12 Time: 13:50
// +----------------------------------------------------------------------
require_once 'vendor/autoload.php';

$id = 1;
$url = 'http://demo.tp5.lmx0536.cn/index/tools.api/get_api/id/' . $id;
$res = curl_get($url);
$obj = json_decode($res,true);
var_dump($obj);

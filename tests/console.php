<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/10/28 Time: 15:13
// +----------------------------------------------------------------------
require_once __DIR__ . '/../src/Debug.php';
use limx\func\Debug;

echo Debug::color('hello world') . "\n";
echo Debug::color('hello world', 'blue') . "\n";
echo Debug::color('hello world', 'green') . "\n";
echo Debug::color('hello world', 'yellow') . "\n";

$arr = [
    'aa' => 'bb',
    'cc' => 'dd',
];
Debug::dump($arr, true, null, true);
Debug::dump($arr, true, null, true, "\n", 'red');
Debug::dump($arr, true, null, true, "\n", 'blue');
Debug::dump("HELLO WORLD!--limx-李铭昕", true, null, true, "\n", 'blue');
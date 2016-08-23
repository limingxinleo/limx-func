<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/23 Time: 11:34
// +----------------------------------------------------------------------
namespace limx\func;
class Log
{
    public static function write($content = '', $file = '', $root = 'cache/', $code = '')
    {
        if (!is_dir($root)) {
            mkdir($root, 0777, true);
        }
        if (substr($root, -1) != '/') {
            $root .= '/';
        }

        if (empty($file)) {
            $file = Date('Ymd') . '.log';
        }
        if (!empty($code)) {
            $content = $code . '<<' . $content;
        }
        file_put_contents($root . $file, $content . "\n", FILE_APPEND);
    }
}
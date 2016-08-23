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
    public static function write($content = '', $code = 'LOG', $file = '', $root = '')
    {
        empty($root) && $root = 'log/' . Date('Ym') . '/';
        if (!is_dir($root)) {
            mkdir($root, 0777, true);
        }
        if (substr($root, -1) != '/') {
            $root .= '/';
        }

        if (empty($file)) {
            $file = Date('Ymd') . '.log';
        }
        $msg[] = Date('Y-m-d H:i:s');
        $msg[] = strtoupper($code);
        $msg[] = is_array($content) ? json_encode($content) : $content;

        $info = implode('|', $msg);
        file_put_contents($root . $file, $info . "\n", FILE_APPEND);
    }
}
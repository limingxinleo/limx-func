<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/16 Time: 11:32
// +----------------------------------------------------------------------
namespace limx\func;
class Debug
{
    /**
     * 浏览器友好的变量输出
     * @param mixed $var 变量
     * @param boolean $echo 是否输出 默认为true 如果为false 则返回输出字符串
     * @param string $label 标签 默认为空
     * @param boolean $cli true 命令行 false网页
     * @return void|string
     */
    public static function dump($var, $echo = true, $label = null, $cli = false, $eol = "\n", $color = '')
    {
        $label = (null === $label) ? '' : rtrim($label) . ':';
        ob_start();
        var_dump($var);

        $output = ob_get_clean();
        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
        if ($cli) {
            $output = $eol . $label . $output . $eol;
        } else {
            if (!extension_loaded('xdebug')) {
                $output = htmlspecialchars($output, ENT_QUOTES);
            }
            $output = '<pre>' . $label . $output . '</pre>';
        }
        if ($echo) {
            if (empty($color)) {
                echo($output);
                return null;
            } else {
                echo self::colorBegin($color);
                echo($output);
                echo self::colorEnd();
                return null;
            }
        } else {
            return $output;
        }
    }

    /**
     * [color desc]
     * @desc 为输出的字符添加颜色 用于console输出
     * @author limx
     * @param string $type
     */
    public static function color($str = '', $type = 'red')
    {
        $color = [
            'red' => "\033[31;1m",
            'green' => "\033[32;1m",
            'yellow' => "\033[33;3m",
            'blue' => "\033[34;3m",
        ];
        $end = "\033[0m";
        return empty($color[$type]) ? $str : $color[$type] . $str . $end;
    }

    /**
     * [colorBegin desc]
     * @desc 颜色的开始标记
     * @author limx
     * @param string $type
     * @return mixed
     */
    public static function colorBegin($type = 'red')
    {
        $color = [
            'red' => "\033[31;1m",
            'green' => "\033[32;1m",
            'yellow' => "\033[33;3m",
            'blue' => "\033[34;3m",
        ];
        return empty($color[$type]) ? $color['red'] : $color[$type];
    }

    /**
     * [colorEnd desc]
     * @desc 颜色的结束标记
     * @author limx
     * @return string
     */
    public static function colorEnd()
    {
        return "\033[0m";
    }
}
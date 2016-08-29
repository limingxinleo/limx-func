<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/15 Time: 11:35
// +----------------------------------------------------------------------
namespace limx\func;
class Time
{
    /**
     * [date_format 获取日期]
     * @author limx
     * @param null $time 时间戳 或 时间格式字符串
     * @param null $change strtotime的参数
     * @param string $format 时间格式
     * @return bool|string
     */
    public static function date_format($time = NULL, $change = NULL, $format = 'Y-m-d')
    {
        empty($now) && $now = time();
        is_string($time) && $time = strtotime($time);
        !empty($change) && $time = strtotime($change, $time);
        return Date($format, $time);
    }

    /**
     * [get_now_time 获取当前时间]
     * @author limx
     * @return bool|string
     */
    public static function get_now_time()
    {
        return Date("Y-m-d H:i:s");
    }

    public static function get_time_diff($time, $now = NULL, $format = 's')
    {
        empty($now) && $now = time();
        is_string($now) && $now = strtotime($now);
        is_string($time) && $time = strtotime($time);
        $ret = $time - $now;
        $isFu = false;
        if ($ret == 0) return 0;
        if ($ret < 0) {
            $ret = -$ret;
            $isFu = true;
        }
        if ($format == 's') $ret = $ret;
        else if ($format == 'i') $ret = intval($ret / 60) + 1;
        else if ($format == 'h') $ret = intval($ret / 3600) + 1;
        else if ($format == 's') $ret = intval($ret / (3600 * 24)) + 1;
        else if ($format == 'w') $ret = intval($ret / (3600 * 24 * 7)) + 1;
        else {
            $month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            $ret = intval($ret / (3600 * 24)) + 1;
            if ($format == 'm') {

            }
        }
        if ($isFu) return -$ret;
        return $ret;
    }

    public static function isleap($time = NULL)
    {
        empty($time) && $time = time();
        is_string($time) && $time = strtotime($time);
        $year = Date('Y', $time);
        if ($year % 400 === 0) return true;
        if ($year % 4 === 0 && $year % 100 !== 0) return true;
        return false;
    }
}
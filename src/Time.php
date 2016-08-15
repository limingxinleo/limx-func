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
    function date_format($time = NULL, $change = NULL, $format = 'Y-m-d')
    {
        if (empty($time)) {
            //初始化数据
            $time = time();
        }
        if (is_string($time)) {
            $time = strtotime($time);
        }
        if (!empty($change)) {
            $time = strtotime($change, $time);
        }

        return Date($format, $time);
    }

    /**
     * [get_now_time 获取当前时间]
     * @author limx
     * @return bool|string
     */
    function get_now_time()
    {
        return Date("Y-m-d H:i:s");
    }
}
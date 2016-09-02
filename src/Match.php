<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/9/1 Time: 14:53
// +----------------------------------------------------------------------
namespace limx\func;
class Match
{
    /**
     * [isInt 判断是否为整数]
     * @desc
     * @author limx
     * @param $id
     * @return bool
     */
    public static function isInt($id)
    {
        if (preg_match("/^-?[0-9]+$/", $id)) {
            return true;
        }
        return false;
    }

    /**
     * [isMobile 判断是否为手机号]
     * @desc
     * @author limx
     * @param $phonenumber 手机号
     * @return bool
     */
    public static function isMobile($phonenumber)
    {
        if (preg_match("/^1[34578]{1}\d{9}$/", $phonenumber)) {
            return true;
        }
        return false;
    }

    /**
     * [isImage 此扩展名是否是图片]
     * @author limx
     * @param $ext 扩展名
     */
    public static function isImage($ext, $lib = [])
    {
        $auth = array_merge(['gif', 'jpg', 'jpeg', 'bmp', 'png', 'swf'], $lib);
        if (in_array($ext, $auth)) {
            return true;
        }
        return false;
    }
}
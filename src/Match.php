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
}
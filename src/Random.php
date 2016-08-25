<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/16 Time: 11:30
// +----------------------------------------------------------------------
namespace limx\func;
class Random
{
    /**
     * [str 生成随即字符串]
     * @desc
     * @author limx
     * @param $intLength 长度
     * @param string $strType 类型 N数字 S字母 C数字字母
     * @return string
     */
    public static function str($intLength, $strType = 'C')
    {
        $arrChars = array();
        if ($strType == "N") {//获取数字随机码
            $arrChars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        } else if ($strType == "S") {//获取字母随机码
            $arrChars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        } else if ($strType == "C") {//获取数字+字母随机码
            $arrChars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        }
        $intCharsLen = count($arrChars) - 1;
        shuffle($arrChars);
        // 将数组打乱
        $strOutput = "";
        for ($i = 0; $i < $intLength; $i++) {
            $strOutput .= $arrChars[mt_rand(0, $intCharsLen)];
            //获得一个数组元素
        }
        return $strOutput;
    }
}
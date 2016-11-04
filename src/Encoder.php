<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/15 Time: 11:26
// +----------------------------------------------------------------------
namespace limx\func;
class Encoder
{
    /**
     * [emoji_filter emoji表情过滤]
     * @author limx
     * @param string $value 字符串
     * @param string $replace 过滤成replace
     * @return string
     */
    public static function emojiFilter($value = "", $replace = "")
    {
        $strEncode = '';
        $length = mb_strlen($value, 'utf-8');
        for ($i = 0; $i < $length; $i++) {
            $_tmpStr = mb_substr($value, $i, 1, 'utf-8');
            if (strlen($_tmpStr) >= 4) {
                $strEncode .= $replace;
            } else {
                $strEncode .= $_tmpStr;
            }
        }
        return $strEncode;
    }

    /**
     * [emoji_encode 微信emoji表情编码]
     * @author limx
     * @param string $value
     * @return string
     */
    public static function emojiEncode($value = "")
    {
        $strEncode = '';
        $length = mb_strlen($value, 'utf-8');
        for ($i = 0; $i < $length; $i++) {
            $_tmpStr = mb_substr($value, $i, 1, 'utf-8');
            if (strlen($_tmpStr) >= 4) {
                $strEncode .= '[[EMOJI:' . rawurlencode($_tmpStr) . ']]';
            } else {
                $strEncode .= $_tmpStr;
            }
        }
        return $strEncode;
    }

    /**
     * [emoji_decode 微信emoji表情解码]
     * @author limx
     * @param string $value
     * @return mixed|string
     */
    public static function emojiDecode($value = "")
    {
        preg_match_all('/\[\[EMOJI:[%\w+]+\]\]/', $value, $match);
        if (empty($match)) {
            return $value;
        }
        $len = count($match[0]);

        for ($i = 0; $i < $len; $i++) {
            $temp = null;
            $temp = str_replace('[[EMOJI:', '', $match[0][$i]);
            $temp = str_replace(']]', '', $temp);
            $temp = rawurldecode($temp);

            $value = str_replace($match[0][$i], $temp, $value);
        }
        return $value;

    }

    /**
     * [base64ToImg base64转化为图片]
     * @desc
     * @author limx
     * @param string $root 图片转存路径
     * @param string $data 数据流
     * @param string $picName 转存后名称
     * @return array|bool|string
     */
    public static function base64ToImg($root = "uploads/", $data = "", $picName = "")
    {
        $is_arr = true;
        if (!is_dir($root)) {
            mkdir($root, 0777, true);
        }

        // 判断目录是否是斜杠结尾，若不是增加斜杠
        $ds = substr($root, strlen($root) - 1, strlen($root));
        if ($ds != '/') {
            $root = $root . '/';
        }

        if (empty($picName)) {
            $picName = date("YmdHis") . rand(0, 99);
        }

        if (!is_array($data)) {
            $data = [$data];
            $is_arr = false;
        }

        $returnData = false;
        foreach ($data as $key => $value) {
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $value, $result)) {
                $type = $result[2];
                $new_file = $root . $picName . $key . ".{$type}";
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $value)))) {
                    if ($is_arr === false) {
                        return $picName . $key . ".{$type}";
                    }
                    $returnData[] = $picName . $key . ".{$type}";
                }
            }
        }
        return $returnData;
    }
}

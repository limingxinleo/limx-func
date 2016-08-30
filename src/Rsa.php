<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/15 Time: 23:32
// +----------------------------------------------------------------------
namespace limx\func;
class Rsa
{
    /**
     * RSA签名
     * @param $data 待签名数据
     * @param $private_key 商户私钥字符串
     * return 签名结果
     */
    public static function rsaSign($data, $private_key)
    {
        //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
        $private_key = str_replace("-----BEGIN RSA PRIVATE KEY-----", "", $private_key);
        $private_key = str_replace("-----END RSA PRIVATE KEY-----", "", $private_key);
        $private_key = str_replace("\n", "", $private_key);

        $private_key = "-----BEGIN RSA PRIVATE KEY-----" . PHP_EOL . wordwrap($private_key, 64, "\n", true) . PHP_EOL . "-----END RSA PRIVATE KEY-----";

        $res = openssl_get_privatekey($private_key);

        if ($res) {
            openssl_sign($data, $sign, $res);
        } else {
            echo "您的私钥格式不正确!" . "<br/>" . "The format of your private_key is incorrect!";
            exit();
        }
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * RSA验签
     * @param $data 待签名数据
     * @param $alipay_public_key 支付宝的公钥字符串
     * @param $sign 要校对的的签名结果
     * return 验证结果
     */
    public static function rsaVerify($data, $alipay_public_key, $sign)
    {
        //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
        $alipay_public_key = str_replace("-----BEGIN PUBLIC KEY-----", "", $alipay_public_key);
        $alipay_public_key = str_replace("-----END PUBLIC KEY-----", "", $alipay_public_key);
        $alipay_public_key = str_replace("\n", "", $alipay_public_key);

        $alipay_public_key = '-----BEGIN PUBLIC KEY-----' . PHP_EOL . wordwrap($alipay_public_key, 64, "\n", true) . PHP_EOL . '-----END PUBLIC KEY-----';
        $res = openssl_get_publickey($alipay_public_key);
        if ($res) {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        } else {
            echo "您的支付宝公钥格式不正确!" . "<br/>" . "The format of your alipay_public_key is incorrect!";
            exit();
        }
        openssl_free_key($res);
        return $result;
    }

    /**
     * [fn_arr_to_str desc]
     * @author limx
     * @param $data 数组
     * @param $type 类型 0:正常 1:key="value" 2:key=urlencode(value) 3:key=\"value\"
     * @return string
     */
    public static function arrToStr($data, $type = 0)
    {
        $res = '';
        foreach ($data as $i => $v) {
            switch ($type) {
                case 1:
                    $res .= $i . '="' . $v . '"&';
                    break;
                case 2:
                    $res .= $i . '=' . urlencode($v) . '&';
                    break;
                case 3:
                    $res .= $i . '=\"' . $v . '\"&';
                    break;
                default:
                    $res .= $i . '=' . $v . '&';
                    break;
            }

        }
        $res = substr($res, 0, strlen($res) - 1);
        return $res;
    }
}
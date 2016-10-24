<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/12 Time: 13:45
// +----------------------------------------------------------------------
namespace limx\func;
class Curl
{
    /**
     * 通过CURL发送HTTP请求
     * @param string $url //请求URL
     * @param array $postFields //请求参数
     * @return mixed
     */
    public static function post($url, $data, $type = 'url', $header = NULL, $ssl = false)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        if ($ssl) {
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $ssl['sslcert_path']);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $ssl['sslkey_path']);
        }

        switch (strtolower($type)) {
            case 'url':
                $postFields = http_build_query($data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                break;
            case 'json':
                $postFields = json_encode($data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($postFields))
                );
                break;
            case 'data':
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                $postFields = http_build_query($data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                break;
        }

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * [get CURL GET 方法]
     * @desc
     * @author limx
     * @param $url
     * @param array $headerData
     * @return mixed
     */
    public static function get($url, $headerData = array())
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //递归的抓取http头中Location中指明的url
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        if (!empty($headerData)) {
            $headerArr = array();
            foreach ($headerData as $i => $v) {
                $headerArr[] = $i . ':' . $v;
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr);
        }
        //执行命令
        $result = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);

        return $result;
    }

    /**
     * [post_json CURL POST JSON 方法]
     * @desc
     * @author limx
     * @param $url
     * @param $data
     * @param array $header
     * @return mixed
     */
    public static function postJson($url, $data, $header = [])
    {
        $data_string = json_encode($data);
        $ch = curl_init($url);
        $header['Content-Type'] = 'application/json';
        $header['Content-Length'] = strlen($data_string);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($header)) {
            $headerArr = [];
            foreach ($header as $i => $v) {
                $headerArr[] = $i . ':' . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        }

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * [getArr]
     * @desc curl GET 方法 允许传入数组
     * @author limx
     * @param $url 请求地址
     * @param array $params 参数
     */
    public static function getArr($url, $params = [])
    {
        $url .= strpos($url, '?') ? '&' : '?';
        return self::get($url . http_build_query($params));
    }
}

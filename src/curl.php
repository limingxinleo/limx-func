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

/**
 * 通过CURL发送HTTP请求
 * @param string $url //请求URL
 * @param array $postFields //请求参数
 * @return mixed
 */
function curl_post($url, $postFields, $headerData = array())
{
    $postFields = http_build_query($postFields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    if (!empty($headerData)) {
        $headerArr = array();
        foreach ($headerData as $i => $v) {
            $headerArr[] = $i . ':' . $v;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function curl_get($url, $headerData = array())
{
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
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

function curl_post_json($url, $data, $header = [])
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
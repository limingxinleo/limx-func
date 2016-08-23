<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/12 Time: 13:50
// +----------------------------------------------------------------------

require_once '../src/Curl.php';
require_once '../src/Encoder.php';
require_once '../src/Time.php';
require_once '../src/Rsa.php';
require_once '../src/Random.php';
require_once '../src/Debug.php';
require_once '../src/Encrypt.php';
require_once '../src/Log.php';
require_once '../src/functions/helper.php';

$id = 1;
$url = 'http://demo.tp5.lmx0536.cn/index/tools.api/get_api/id/' . $id;
$res = limx\func\Curl::get($url);
$obj = json_decode($res, true);
limx\func\Debug::dump($obj);
limx\func\Debug::dump(limx\func\Time::get_now_time());

limx\func\Debug::dump(limx\func\Time::date_format(time(), '+1 week'));

$private_key = 'MIICXQIBAAKBgQDXJHKBZnonQEiT6WeJ8JiYHSdZuWTEAJpvsUfMO0s/Lp+zS8Xa
ZmP/exGC75zveAvdRXsg20cZpTt6HtUYs/ZuHJl2HsiTIKlnmaDGMxNq7yCW7hAe
BgXUjJGG8jUhQUI4BGDN/16S3WLFHBYJFahRQ7TibIdvAMkovqU0wO0KWwIDAQAB
AoGAecit8MX7m8Bt1RyoeZLyLhlCry2c9r6IrXUi+V8PJ0LTMAFSjGCtdm9J6F6O
7Zd8z9KG8oBt7Px1gJl3czZb5csju8eskWsSDjMCrWUtC7TchtVwbG5hi92A1qgX
/0HBI75aFlTF9Mb2BvEt3IyxrglDolrXx89u/jDDaGMUpYECQQDr9Nt7hIL9TkqP
LdC8bc8gaoLhACaSPpBt1yzzApCQtHwLaahCcTIoavI/p3cNM44DNU+GMw7ugq1W
b4MtGUFhAkEA6Wr2qzaHvhXySneX4MMN8dkC8AscBSW/e4JUvvY6/8xB7miaYWiy
AQHw0LkOzn03xQjJ75pmAuiw7hzQ2QiZOwJAUMNe3MhejZVer+NeryBm5RGP+rOy
gBwqE26zU/pswRsF2mIv1Y4pPOxePqtzdHFRCogU0Dppwfm4mv1QSP98AQJBAKPs
a4j4BcJ31S146Z9+PGfROJ/tnWL8DIqnj+6ALBUClHbi3TB1fzT38PAUVpKrG6Rz
NKXhb6yxT7gZYo5Y3IsCQQCchbuOogFGPR5gcKGghSlg3Bqo4vV6PfrsLaJiSirB
NaoLi8ssq9w93e/nzV9hyLTK1hwz9FIFuVKBOGtjvfGy';
$public_key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDXJHKBZnonQEiT6WeJ8JiYHSdZ
uWTEAJpvsUfMO0s/Lp+zS8XaZmP/exGC75zveAvdRXsg20cZpTt6HtUYs/ZuHJl2
HsiTIKlnmaDGMxNq7yCW7hAeBgXUjJGG8jUhQUI4BGDN/16S3WLFHBYJFahRQ7Ti
bIdvAMkovqU0wO0KWwIDAQAB';
$data = [
    'name' => 'limx',
    'wife' => 'yy',
    'url' => 'http://www.lmx0536.cn/'
];
$sign_str = limx\func\Rsa::arr_to_str($data);
$sign = limx\func\Rsa::rsa_sign($sign_str, $private_key);
$check = limx\func\Rsa::rsa_verify($sign_str, $public_key, $sign);
limx\func\Debug::dump($sign);
limx\func\Debug::dump($check);

$str = limx\func\Random::str(6, 'C');
limx\func\Debug::dump($str);

$str = limx\func\Encrypt::encode($str);
limx\func\Debug::dump($str);
$str = limx\func\Encrypt::decode($str);
limx\func\Debug::dump($str);
$str = limx\func\Encrypt::encode($str, 'love');
limx\func\Debug::dump($str);
$str = limx\func\Encrypt::decode($str, 'love');
limx\func\Debug::dump($str);

$res = [];
traverse(__DIR__ . '/../', $res, 'php');
limx\func\Debug::dump($res);
$res = [];
traverse(__DIR__ . '/..', $res, 'php');
limx\func\Debug::dump($res);

limx\func\Log::write($str);
limx\func\Log::write($res, 'arr');






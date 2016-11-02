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

namespace limx\func;
require_once __DIR__ . '/../src/functions/helper.php';
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/../src/' . $class_name . '.php';
    $file = str_replace('limx\func\\', '', $file);
    if (file_exists($file)) {
        include $file;
    }
});

use limx\func\Debug;
use limx\func\Utils;

function dump($data)
{
    Debug::dump($data);
}

dump(Utils::ip());

$url = 'http://demo.tp5.lmx0536.cn/index/demos.tp5/test_input/key1/aa/key2/bb?key3=cc';
$res = Curl::getArr($url, ['key4' => 'dd']);
echo $res;

$config = [
    'd' => ['a' => 1],
];
Debug::dump(Arr::get('d.a', $config));

Debug::dump(Match::isInts('21'));
Debug::dump(Match::isInts('10//11,21'));
Debug::dump(Match::isInts('15,-11,222,21'));
$res = File::copy(__DIR__, ['log/201609/', '201608'], 'test');
Debug::dump($res);

Debug::dump(Match::isImage('aa.aaa', ['aaa']));
Debug::dump(Match::isImage('aa.png', ['aaa']));
Debug::dump(Match::isImage('aa.aaa'));

$url = 'http://demo.tp5.lmx0536.cn/index/demos.tp5/test_input/key1/aa/key2/bb?key3=cc';
$res = Curl::get($url);
echo $res;
$url = 'http://demo.tp5.lmx0536.cn/index/demos.tp5/test_input/key1/aa/key2/bb?key3=cc';
$data = ['key1' => 'postData1', 'key2' => 'pData2'];
$res = Curl::post($url, $data);
echo $res;

Debug::dump(Time::now());

Debug::dump(Time::format(time(), '+1 week'));

Debug::dump(Time::diff('2016-12-30', time(), 'i'));
Debug::dump(Time::diff(time(), '2016-12-30', 'h'));
Debug::dump(Time::diff('2016-12-30', time(), 'd'));
Debug::dump(Time::isleap());

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
$sign_str = Rsa::arrToStr($data);
$sign = Rsa::rsaSign($sign_str, $private_key);
$check = Rsa::rsaVerify($sign_str, $public_key, $sign);
Debug::dump($sign);
Debug::dump($check);

$str = Random::str(6, 'C');
Debug::dump($str);

$str = Encrypt::encode($str);
Debug::dump($str);
$str = Encrypt::decode($str);
Debug::dump($str);
$str = Encrypt::encode($str, 'love');
Debug::dump($str);
$str = Encrypt::decode($str, 'love');
Debug::dump($str);

$res = [];
traverse(__DIR__ . '/../', $res, 'php');
Debug::dump($res);
$res = [];
traverse(__DIR__ . '/..', $res, 'php');
Debug::dump($res);

Log::write($str);
Log::write($res, 'arr');

$res = Match::isInt(-1);
Debug::dump($res);
$res = Match::isInt(100);
Debug::dump($res);
$res = Match::isInt('ss');
Debug::dump($res);






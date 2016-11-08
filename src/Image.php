<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/9/18 Time: 15:21
// +----------------------------------------------------------------------
namespace limx\func;

class Image
{
    /**
     * [compress 图片压缩]
     * @author limx
     * @param $image 图片源地址
     * @param int $dw 宽度
     * @param int $dh 高度
     * @param int $type 压缩类型
     * @param string $ex 压缩文件名后缀
     * @return bool
     */
    public static function compress($image, $dw = 450, $dh = 450, $type = 2, $ex = "_x")
    {
        if (!file_exists($image)) {
            return false;
        } // 如果需要生成缩略图,则将原图拷贝一下重新给$image赋值
        if ($type != 1) {
            copy($image, str_replace(".", $ex . ".", $image));
            $image = str_replace(".", $ex . ".", $image);
        } // 取得文件的类型,根据不同的类型建立不同的对象
        $ImgInfo = getimagesize($image);
        switch ($ImgInfo[2]) {
            case 1:
                $Img = @imagecreatefromgif($image);
                break;
            case 2:
                $Img = @imagecreatefromjpeg($image);
                break;
            case 3:
                $Img = @imagecreatefrompng($image);
                break;
        } // 如果对象没有创建成功,则说明非图片文件
        if (empty($Img)) { // 如果是生成缩略图的时候出错,则需要删掉已经复制的文件
            if ($type != 1) {
                unlink($image);
            }
            return false;
        } // 如果是执行调整尺寸操作则
        if ($type == 1) {
            $w = imagesx($Img);
            $h = imagesy($Img);
            $width = $w;
            $height = $h;
            if ($width > $dw) {
                $Par = $dw / $width;
                $width = $dw;
                $height = $height * $Par;
                if ($height > $dh) {
                    $Par = $dh / $height;
                    $height = $dh;
                    $width = $width * $Par;
                }
            } elseif ($height > $dh) {
                $Par = $dh / $height;
                $height = $dh;
                $width = $width * $Par;
                if ($width > $dw) {
                    $Par = $dw / $width;
                    $width = $dw;
                    $height = $height * $Par;
                }
            } else {
                $width = $width;
                $height = $height;
            }
            $nImg = imagecreatetruecolor($width, $height); // 新建一个真彩色画布
            imagecopyresampled($nImg, $Img, 0, 0, 0, 0, $width, $height, $w, $h); // 重采样拷贝部分图像并调整大小
            imagejpeg($nImg, $image); // 以JPEG格式将图像输出到浏览器或文件
            return true; // 如果是执行生成缩略图操作则
        } else {
            $w = imagesx($Img);
            $h = imagesy($Img);
            $width = $w;
            $height = $h;
            $nImg = imagecreatetruecolor($dw, $dh);
            if ($h / $w > $dh / $dw) { // 高比较大
                $width = $dw;
                $height = $h * $dw / $w;
                $IntNH = $height - $dh;
                imagecopyresampled($nImg, $Img, 0, -$IntNH / 1.8, 0, 0, $dw, $height, $w, $h);
            } else { // 宽比较大
                $height = $dh;
                $width = $w * $dh / $h;
                $IntNW = $width - $dw;
                imagecopyresampled($nImg, $Img, -$IntNW / 1.8, 0, 0, 0, $width, $dh, $w, $h);
            }
            imagejpeg($nImg, $image);
            return true;
        }
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

    /**
     * [imageSize desc]
     * @desc 获取图片长宽 和 大小
     * @desc 只有本地图片才能获取大小 type=fread
     * @author limx
     * @param $url 图片地址 可以是网络图片 也可以是 本地图片
     * @param string $type 获取长宽的方式
     * @param bool $isGetFilesize 是否获取大小
     * @return bool|array('size','width','height')
     */
    public static function imageSize($url, $type = 'curl', $isGetFilesize = false)
    {
        // 若需要获取图片体积大小则默认使用 fread 方式
        $type = $isGetFilesize ? 'fread' : $type;

        if ($type == 'fread') {
            // 或者使用 socket 二进制方式读取, 需要获取图片体积大小最好使用此方法
            $handle = fopen($url, 'rb');

            if (!$handle) return false;

            // 只取头部固定长度168字节数据
            $dataBlock = fread($handle, 168);
        } else {
            // 据说 CURL 能缓存DNS 效率比 socket 高
            $ch = curl_init($url);
            // 超时设置
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            // 取前面 168 个字符 通过四张测试图读取宽高结果都没有问题,若获取不到数据可适当加大数值
            curl_setopt($ch, CURLOPT_RANGE, '0-300');
            // 跟踪301跳转
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            // 返回结果
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $dataBlock = curl_exec($ch);

            curl_close($ch);

            if (!$dataBlock) return false;
        }

        // 将读取的图片信息转化为图片路径并获取图片信息,经测试,这里的转化设置 jpeg 对获取png,gif的信息没有影响,无须分别设置
        // 有些图片虽然可以在浏览器查看但实际已被损坏可能无法解析信息
        $size = getimagesize('data://image/jpeg;base64,' . base64_encode($dataBlock));
        if (empty($size)) {
            return false;
        }

        $result['width'] = $size[0];
        $result['height'] = $size[1];

        // 是否获取图片体积大小
        if ($isGetFilesize) {
            // 获取文件数据流信息
            $result['size'] = filesize($url);
        }

        if ($type == 'fread') fclose($handle);

        return $result;
    }
}
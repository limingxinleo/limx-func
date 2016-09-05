<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/9/5 Time: 9:01
// +----------------------------------------------------------------------
namespace limx\func;

use ZipArchive;

class File
{
    /**
     * [copy 文件复制]
     * @author limx
     * @param $root 根目录
     * @param array $src 根目录下的文件夹或者文件
     * @param string $dst 目标根目录
     * @return bool
     */
    public static function copy($root, $src = [], $dst = '')
    {
        if (empty($root)) return false;
        if (substr($root, -1) != '/') $root = $root . '/';
        if (substr($dst, -1) != '/') $dst = $dst . '/';
        if (!is_array($src)) $src = [$src];

        //判断源文件是否存在?
        foreach ($src as $val) {
            if (file_exists($root . $val)) {
                if (!self::_copy($root, $val, $dst)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * [zip 打包函数]
     * @author limx
     * @param $root 源文件根目录
     * @param $src 需要压缩的相对目录名
     * @param $ziproot 压缩文件的根目录
     * @param string $zipname 压缩文件的相对目录名
     * @param bool $del 是否压缩后删除源文件
     * @return bool|mixed
     */
    public static function zip($root, $src, $ziproot, $zipname = '', $del = false)
    {
        if (empty($root)) return false;
        if (substr($root, -1) != '/') $root = $root . '/';
        if (empty($src)) return false;
        if (empty($ziproot)) return false;
        if (substr($ziproot, -1) != '/') $ziproot = $ziproot . '/';
        empty($zipname) && $zipname = $src . time() . '.zip';
        //建立一个新的ZipArchive的对象
        $zip = new \ZipArchive();
        $res = $zip->open($ziproot . $zipname, \ZipArchive::CREATE);
        //如果打开成功
        if ($res === true) {
            $files = [];
            traverse($root . $src, $files);
            foreach ($files as $i => $v) {
                $av = str_replace($root, '', $v);
                $zip->addFile($v, $av);
            }
            $zip->close();
            if ($del) {
                self::rm($root . $src);
            }
        }
        return $res;
    }

    /**
     * [rm 删除整个目录]
     * @author limx
     * @param $src 目录地址
     * @return bool
     */
    public static function rm($src)
    {
        if (empty($src)) return false;
        $ls = scandir($src);
        for ($i = 0; $i < count($ls); $i++) {
            if ($ls[$i] == '.' or $ls[$i] == '..') continue;
            $_dst = $src . $ls[$i];
            if (!is_dir($_dst)) {
                unlink($_dst);
            } else {
                self::rm($_dst);
            }
        }
        //删除当前文件夹：
        if (rmdir($src)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * [_copy 文件复制]
     * @author limx
     * @param $root 根目录
     * @param $src 根目录下的文件夹或者文件
     * @param $dst 目标根目录
     * @return bool
     */
    private static function _copy($root, $src, $dst)
    {
        if (!is_dir($root . $src)) {
            //复制路径结构
            $dstdir = dirname($dst . $src);
            if (!is_dir($dstdir)) {
                mkdir($dstdir, 0775, true);
            }
            if (!copy($root . $src, $dst . $src)) {
                return false;
            }
        } else {
            if (substr($src, -1) != '/') $src = $src . '/';
            $ls = scandir($root . $src);

            for ($i = 0; $i < count($ls); $i++) {
                if ($ls[$i] == '.' or $ls[$i] == '..') continue;
                $_dst = $dst . $src . $ls[$i];
                if (!self::_copy($root . $src, $ls[$i], $dst . $src)) {
                    return false;
                };
            }
        }
        return true;
    }
}
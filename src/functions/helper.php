<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/8/17 Time: 16:26
// +----------------------------------------------------------------------

if (!function_exists('array_column')) {
    /**
     * [array_column 获取数组中的某一列]
     * @author limx
     * @param $input 数组
     * @param $columnKey string：key值 int：角标 Key
     * @param null $indexKey 返回数组的key值 NULL时默认为角标
     * php7 中似乎有array_column函数 功能一样
     * @return array
     */
    function array_column($input, $columnKey, $indexKey = NULL)
    {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
        $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
        $result = array();

        foreach ((array)$input AS $key => $row) {
            if ($columnKeyIsNumber) {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
            } else {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
            }
            if (!$indexKeyIsNull) {
                if ($indexKeyIsNumber) {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key)) ? current($key) : NULL;
                    $key = is_null($key) ? 0 : $key;
                } else {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }
}

if (!function_exists('traverse')) {
    function traverse($path, &$result, $ext = "")
    {
        if (substr($path, -1) == '/') {
            $path = substr($path, 0, strlen($path) - 1);
        }
        $curr = glob($path . '/*');
        $len = strlen($ext) + 1;
        if ($curr) {
            foreach ($curr as $f) {
                if (is_dir($f)) {
                    traverse($f, $result, $ext);
                } elseif (empty($ext)) {
                    array_push($result, $f);
                } elseif (strtolower(substr($f, 0 - $len)) == '.' . $ext) {
                    array_push($result, $f);
                }
            }
        }
    }
}

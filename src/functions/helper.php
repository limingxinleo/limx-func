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
    /**
     * [traverse 遍历文件]
     * @author limx
     * @param $path 文件夹
     * @param $result 结果集合
     * @param string $ext 扩展名
     */
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

if (!function_exists('multiarray')) {
    /**
     * [multiarray 将带父级ID的数组重新组合成为kv的二维数组]
     * @author limx
     * @param array $data 需要整理的数据源
     * @param string $key 数据源的主键
     * @param string $pkey 数据源的父ID
     * @param string $pvalue 数据源父ID 的值
     * @param string $ckey
     * @param bool $isFirst
     * @return array
     */
    function multiarray($data = [], $key = 'id', $pkey = '', $pvalue = '', $ckey = 'children', $isFirst = true)
    {
        if (empty($pkey)) {
            return $data;
        }
        $result = [];
        foreach ($data as $i => $v) {
            empty($result[$v[$key]]) && $result[$v[$key]] = [];
            $result[$v[$key]] = $result[$v[$key]] + $v;

            if ($isFirst) {
                if ($v[$pkey] == $pvalue) {
                    empty($result[$pvalue][$v[$key]]) && $result[$pvalue][$v[$key]] = [];
                    $result[$pvalue][$v[$key]] = $result[$pvalue][$v[$key]] + $v;
                } else {
                    $temp = multiarray([$v], $key, $pkey, $v[$pkey], $ckey, false);
                    empty($result[$v[$pkey]][$ckey]) && $result[$v[$pkey]][$ckey] = [];
                    $result[$v[$pkey]][$ckey] = $result[$v[$pkey]][$ckey] + $temp;
                }
            }
        }
        return $result;
    }
}

if (!function_exists('obj_to_array')) {
    /**
     * [obj_to_array object递归转化为array]
     * @author limx
     * @param $e object
     * @return array|void
     */
    function obj_to_array($e)
    {
        $e = (array)$e;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'resource') return;
            if (gettype($v) == 'object' || gettype($v) == 'array')
                $e[$k] = obj_to_array($v);
        }
        return $e;
    }
}

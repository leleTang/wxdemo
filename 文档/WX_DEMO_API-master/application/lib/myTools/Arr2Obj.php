<?php

/**
 * Created by PhpStorm.
 * User: zhangfan2
 * Date: 2016/11/3
 * Time: 12:45
 */
namespace app\lib\myTools;
class Arr2Obj
{
    public static function array2object($array)
    {
        $temp=json_encode($array);
        $obj=json_decode($temp);
        return $obj;
    }

    public static function object2array($object)
    {
        //这方法也是没谁了，但是效率不够好，但是能实现效果
        $temp=json_encode($object);
        $array=json_decode($temp,true);
        return $array;
    }
}
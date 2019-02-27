<?php
/**
 * Created by PhpStorm.
 * User: zhangfan2
 * Date: 2016/11/3
 * Time: 12:33
 * 自助XML解析器，将XML数据解析成数组
 * 接收一个url为参数
 */
namespace app\lib\myTools;
//引入数组转对象类
include_once("./Arr2Obj.class.php");

class XMLAnalysis
{
    private $url,$a=null;
    public function __construct($url=null, $a=null)
    {
        //通过参数实现的伪重载
        if ($url == null) {
            //默认不传入参数时为config的解析,但是必须写绝对路径
            $this->url ="config.xml";
        }else{
            $this->url=$url;
        }
        if ($a == null) {
            $this->a = 0;
        }else{
            $this->a=$a;
        }
    }

    function getXMLAnalysis()
    {
        //这个方法暂时只能载入本地的xml
        $values=simplexml_load_file($this->url);
        if ($this->a == 0) {
//            var_dump($values);
            $data = Arr2Obj::object2array($values);
        } else {
            $data = $values;
        }
        return $data;
    }

    function get_utf8_string($content) {    //  将一些字符转化成utf8格式
        $encoding = mb_detect_encoding($content, array('ASCII','UTF-8','GB2312','GBK','BIG5'));
        return  mb_convert_encoding($content, 'utf-8', $encoding);
    }
}
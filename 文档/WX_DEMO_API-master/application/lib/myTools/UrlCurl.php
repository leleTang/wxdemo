<?php
namespace app\lib\myTools;
/**
 * Created by PhpStorm.
 * User: zhangfan2
 * Date: 2016/11/3
 * Time: 17:20
 */
include_once('M_Log.class.php');
class UrlCurl
{
    //构造方法
    public function __construct()
    {
    }

    //post请求
    static function  curlPost($url,$request,$timeout=5){
        //实例化Log
        $log=new M_Log();
        if($url==''||$request==''||$timeout<=0){
            $log->toolsLog("CURL Error:请检查相应的请求参数，或者超时:url=".$url."req=".$request."时间：".$timeout);
            return false;
        }
        //初始化
        
        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_POSTFIELDS, http_build_query($request));
        curl_setopt($con, CURLOPT_POST,true);
        curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($con, CURLOPT_TIMEOUT,(int)$timeout);
        $output = curl_exec($con);
        if ($output === FALSE) {
            $log->toolsLog("CURL Error:返回错误" . curl_error($con)) ;
        }

        return  json_decode($output,true);
    }

    //get请求
    static function curlGet($url,$data,$timeout=5){
        //实例化Log
        $log=new M_Log();
        if($url==''||$timeout<=0){
            $log->toolsLog("CURL Error:请检查相应的请求参数，或者超时:url=".$url."请求（可以为null）=".$data."时间：".$timeout);
            return false;
        }
        //初始化
        $url = $url.'?'.http_build_query($data);
        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
        $output = curl_exec($con);
        if ($output === FALSE) {
            $log->toolsLog("CURL Error:返回错误" . curl_error($con)) ;
        }else{
            $log->baseLog("CURL Success:" .$output) ;
        }
        return $output;
    }

    //构建PostData,这个主要是解决数组不能发送读取的问题
    /*这里存在一个问题，对于http_build_query(）这个方法，当单独使用二维数组时，是没有问题的，但是如果在二维数组中还存在一个，那么就会出现问题*/
    public function buildPostData($data)
    {
        if(is_array($data)){
            foreach ($data as $key => $val){
            }
        }
        return $data;
    }

}
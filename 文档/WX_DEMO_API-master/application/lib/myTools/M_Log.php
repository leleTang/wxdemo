<?php
/**
 * Created by PhpStorm.
 * User: zhangfan2
 * Date: 2016/11/3
 * Time: 10:33
 * 开始自己的日志打印类
 */
namespace app\lib\myTools;
//引入配置文件的解析
//include_once("XMLAnalysis.php");
include_once("GetHostInfo.php");
class M_Log
{
    private $baseLogUrl,$debugLogUrl,$toolsLogUrl,$ip,$base2LogUrl;
    //构造方法
    public function __construct()
    {
        $date=date('Y-m-d');
        $temp_url=dirname(__FILE__)."/../../../myCacheLog/APILog";
        $this->baseLogUrl=$temp_url."/BaseLog/".$date.'.log';
        $this->base2LogUrl=$temp_url."/APILog/".$date.'.log';
        $this->debugLogUrl=$temp_url."/DebugLog/".$date.'.log';
        $this->toolsLogUrl=$temp_url."/ToolsLog/".$date.'.log';
        $temp=new GetHostInfo();
        $this->ip=$temp::getIP();
    }

    //debug 日志
    function debugLog($info)
    {
        $time = date('m-d H:i:s');
        $backtrace = debug_backtrace();
        $backtrace_line = array_shift($backtrace); // 哪一行调用的log方法
        $backtrace_call = array_shift($backtrace); // 谁调用的log方法
        $file = substr($backtrace_line['file'], strlen($_SERVER['DOCUMENT_ROOT']));
        $line = $backtrace_line['line'];
        $class = isset($backtrace_call['class']) ? $backtrace_call['class'] : '';
        $type = isset($backtrace_call['type']) ? $backtrace_call['type'] : '';
        $func = $backtrace_call['function'];
        file_put_contents($this->debugLogUrl, "$time $this->ip $file:$line $class$type$func: $info\n", FILE_APPEND);
    }

    //打印追踪日志
    function toolsLog($format)
    {
        $args = func_get_args();
        array_shift($args);
        $d = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0];
        $info = vsprintf($format, $args);
        $data = sprintf("%s %s,%d: %s\n", date("Ymd His"), $d["file"], $d["line"], $info);
        file_put_contents($this->toolsLogUrl, $data, FILE_APPEND);
    }

    //基本的打印API请求日志输出
    function tokenLog($info)
    {
        return file_put_contents($this->baseLogUrl, date("Y-m-d H:i:s") .$this->ip. " " . $info . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    //基本的打印API请求日志输出
    function APILog($info)
    {
        return file_put_contents($this->base2LogUrl, date("Y-m-d H:i:s") .$this->ip. " " . $info . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

}

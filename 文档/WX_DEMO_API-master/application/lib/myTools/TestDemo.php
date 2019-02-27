<?php
include_once("./UrlCurl.class.php");
$url='http://localhost/csp/csp/index.php/Home/test/test2';
$data=array(
    1=>'wo',
);
$curl=new UrlCurl();
$temp=$curl->curlGet($url,$data);
var_dump($temp);

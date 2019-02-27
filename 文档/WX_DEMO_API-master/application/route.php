<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//主页路由
Route::rule('/','Index/index','GET');
Route::rule('api/devlogin','index/API/getToken','POST');
Route::rule('api/register','index/API/createUser','POST');
Route::rule('api/login','index/API/loginUser','POST');
Route::rule('api/write','index/API/createArticle','POST');
Route::rule('api/read','index/API/getArticle','POST');
Route::rule('api/list','index/API/getArticleList','POST');
Route::rule('api/delete','index/API/delArticle','POST');
Route::rule('api/plist','index/API/getPublicArticleList','POST');
Route::rule('api/pread','index/API/getPublicArticle','POST');
//仅供测试
//Route::rule('api/test','index/API/index','GET');
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];

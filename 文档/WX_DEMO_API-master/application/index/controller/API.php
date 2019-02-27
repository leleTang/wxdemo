<?php
/**
 * Created by PhpStorm.
 * User: zhangfan2
 * Date: 2016/12/2
 * Time: 10:19
 */
namespace app\index\controller;

use think\Db;
use \think\Request;
use \app\lib\myTools\M_Log;

class API
{
    //基础秘钥
    private $password = "DsmMdsM";
    private $password2='MY1Gdd';


    //获取令牌值
    public function getToken()
    {
        $request = Request::instance();
        $password_post = $request->param('password');
        $email_post = $request->param('email');
        $this->createLog("password:" . $password_post . "|email:" . $email_post);
        if ($password_post ==$this->password.$this->password2) {
            //验证成功，存储入数据库，并且返回Token
            //这里需要有一个判断是否是之前已经生成的数据库信息，如果已经生成，直接返回一致的信息
            $data = Db::table('nkbh_devtoken')->where('email', $email_post)->select();
            if ($data) {
                //存在时直接返回token
                $return = $this->createJson(1, '您之前已经建立token', $data[0]['token']);
            } else {
                $token = md5($email_post . time());
                $data_save = array(
                    'token' => $token,
                    'email' => $email_post,
                    'time' => time()
                );
                if (Db::table('nkbh_devtoken')->insert($data_save)) {
                    $return = $this->createJson(1, '您成功的建立了token，请牢记', $token);
                } else {
                    $return = $this->createJson(0, '未成功建立，请联系我', null);
                }
            }
        } else {
            $return = $this->createJson(0, '您获取token密码错误，请重新输入', null);
        }
        return json($return);
    }

    //通过用户名和密码建立用户
    public function createUser()
    {
        //需要首先验证token
        $request = Request::instance();
        $token_post = $request->param('token');
        $username_post = $request->param('username');
        $password_post = $request->param('password');
        $this->createAPILog("*createUser***|token:" . $token_post . "|username" . $username_post . "|password" . $password_post);
        $tokenid = $this->checkToken($token_post);
        if ($tokenid) {
            $user = Db::table('nkbh_devselfuser')->where(array('tokenid' => $tokenid, 'username' => $username_post))->select();
            if ($user) {
                $return = $this->createJson(0, '账号已存在，请不要重复注册', null);
            } else {
                $userToken = md5(time() . $username_post . $tokenid);
                $data = array(
                    'username' => $username_post,
                    'password' => $password_post,
                    'tokenid' => $tokenid,
                    //验证是否用户token过期的时间，默认为1周
                    'date' => time() + 604800,
                    //建立用户Token
                    'usertoken' => $userToken
                );
                if (Db::table('nkbh_devselfuser')->insert($data)) {
                    $return = $this->createJson(1, "注册成功", json_encode(array('username' => $username_post, 'userToken' => $userToken)));
                } else {
                    $return = $this->createJson(0, "系统可能被玩坏了，请联系我", null);
                }
            }
        } else {
            $return = $this->createJson(0, '您验证token密码错误', null);
        }
        return json($return);
    }

    //登录接口
    public function loginUser()
    {
        //需要首先验证Usertoken
        $request = Request::instance();
        $token_post = $request->param('token');
        $username_post = $request->param('username');
        $password_post = $request->param('password');
        $userToken = $request->param('usertoken');
        $this->createAPILog("*login***|token:" . $token_post . "|username" . $username_post . "|password" . $password_post . "|userToken:" . $userToken);
        $userTokenStatus = $this->checkUserToken($userToken);
        if ($userTokenStatus == 0 || $userTokenStatus == 1) {
            $tokenid = $this->checkToken($token_post);
            if ($tokenid) {
                $temp = array(
                    'username' => $username_post,
                    'password' => $password_post,
                    'tokenid' => $tokenid
                );
                Db::table('nkbh_devselfuser')->where($temp)->update(['usertoken' => md5(time() . $username_post . $tokenid), 'date' => time() + 604800]);
                $user = Db::table('nkbh_devselfuser')->field('username,usertoken')->where($temp)->select();
                if ($user) {
                    $return = $this->createJson(1, null, json_encode($user[0]));
                } else {
                    if ($username_post == '' && $password_post == '') {
                        $return = $this->createJson(0, "您长时间未登录，请重新登录", null);
                    } else {
                        $return = $this->createJson(0, "您的登录用户名或者密码错误", null);
                    }
                }
            } else {
                if ($username_post == '' && $password_post == '') {
                    $return = $this->createJson(0, "您长时间未登录，请重新登录", null);
                } else if ($tokenid == '') {
                    $return = $this->createJson(0, "您未传递开发者Token", null);
                } else {
                    $return = $this->createJson(0, "您的登录用户名或者密码错误", null);
                }
            }
        } else {
            $user = Db::table('nkbh_devselfuser')->field('username,usertoken')->where('usertoken', $userToken)->select();
            if ($user) {
                $return = $this->createJson(1, null, json_encode($user[0]));
            } else {
                $return = $this->createJson(0, "系统可能被玩坏了，请联系我", null);
            }
        }
        return json($return);
    }

    //日记上传API
    public function createArticle()
    {
        $request = Request::instance();
        $token_post = $request->param('token');
        $userToken = $request->param('usertoken');
        //日记
        $article = array(
            'title' => $request->param('title'),
            'date' => $request->param('date'),
            'view' => 0,
            'text' => $request->param('text'),
            'status' => $request->param('status')
        );
        $tokenid = $this->checkToken($token_post);
        $this->createAPILog("*Article***|token:" . $token_post . "|userToken" . $userToken . "|article" . json_encode($article));
        //这里只检测tokenid
        if ($tokenid) {
            $uid = Db::table('nkbh_devselfuser')->field('id')->where('usertoken', $userToken)->select();
            if ($uid) {
                $article['uid'] = $uid[0]['id'];
                $article['tokenid'] = $tokenid;
                if (Db::table('nkbh_userarticle')->insert($article)) {
                    $return = $this->createJson(1, "添加新日志成功！", null);
                } else {
                    $return = $this->createJson(0, "系统可能被玩坏了，请联系我", null);
                }
            } else {
                $return = $this->createJson(0, "提交错误，用户不存在", null);
            }
        } else {
            $return = $this->createJson(0, "您未传递开发者Token", null);
        }
        return json($return);
    }

    //个人列表读取API
    public function getArticleList()
    {
        $request = Request::instance();
        $token_post = $request->param('token');
        $userToken = $request->param('usertoken');
        $tokenid = $this->checkToken($token_post);
        $this->createAPILog("*AList***|token:" . $token_post . "|userToken" . $userToken);
        //这里只检测tokenid
        if ($tokenid) {
            $uid = Db::table('nkbh_devselfuser')->field('id,username')->where('usertoken', $userToken)->select();
            if ($uid) {
                $temp = $uid[0]['id'];
                $articleList = Db::table('nkbh_userarticle')->field("id,title,date,view,status")->where('uid', $temp)->select();
                $return = $this->createJson(1, "", json_encode($articleList));
            } else {
                $return = $this->createJson(0, "提交错误，用户不存在", null);
            }
        } else {
            $return = $this->createJson(0, "您未传递开发者Token", null);
        }
        return json($return);
    }

    //个人日记读取API
    public function getArticle()
    {
        $request = Request::instance();
        $token_post = $request->param('token');
        $userToken = $request->param('usertoken');
        $articleid = $request->param('articleid');
        $tokenid = $this->checkToken($token_post);
        $this->createAPILog("*getArticle***|token:" . $token_post . "|userToken" . $userToken);
        if ($tokenid) {
            $uid = Db::table('nkbh_devselfuser')->field('id,username')->where('usertoken', $userToken)->select();
            if ($uid) {
                $temp['uid'] = $uid[0]['id'];
                $temp['id'] = $articleid;
                $article = Db::table('nkbh_userarticle')->where($temp)->select();
                if ($article) {
                    $return = $this->createJson(1, null, json_encode($article));
                } else {
                    $return = $this->createJson(0, '文章不存在', null);
                }
            } else {
                $return = $this->createJson(0, "提交错误，用户不存在", null);
            }
        } else {
            $return = $this->createJson(0, "您未传递开发者Token", null);
        }
        return json($return);
    }

    //个人日记删除API
    public function delArticle()
    {
        $request = Request::instance();
        $token_post = $request->param('token');
        $userToken = $request->param('usertoken');
        $articleid = $request->param('articleid');
        $tokenid = $this->checkToken($token_post);
        $this->createAPILog("*delArticle***|token:" . $token_post . "|userToken" . $userToken);
        if ($tokenid) {
            $uid = Db::table('nkbh_devselfuser')->field('id,username')->where('usertoken', $userToken)->select();
            if ($uid) {
                $temp['uid'] = $uid[0]['id'];
                $temp['id'] = $articleid;
                $article = Db::table('nkbh_userarticle')->where($temp)->delete();
                if ($article) {
                    $return = $this->createJson(1, "删除成功！", null);
                } else {
                    $return = $this->createJson(0, '文章不存在', null);
                }
            } else {
                $return = $this->createJson(0, "提交错误，用户不存在", null);
            }
        } else {
            $return = $this->createJson(0, "您未传递开发者Token", null);
        }
        return json($return);
    }

    //公众日记列表读取API
    public function getPublicArticleList()
    {
        $request = Request::instance();
        $token_post = $request->param('token');
        $userToken = $request->param('usertoken');
        $tokenid = $this->checkToken($token_post);
        $this->createAPILog("*AList***|token:" . $token_post . "|userToken" . $userToken);
        //这里只检测tokenid
        if ($tokenid) {
            $uid = Db::table('nkbh_devselfuser')->field('id,username')->where('usertoken', $userToken)->select();
            if ($uid) {
                $temp = $uid[0]['id'];
                $articleList = Db::table('nkbh_userarticle')->field("id,title,date,uid")->where('status',1 OR 'uid',$temp)->select();
                foreach ($articleList as $k => $v) {
                    $username = Db::table('nkbh_devselfuser')->field('username')->where('id', $v['uid'])->find();
                    $articleList[$k]['username'] = $username['username'];
                }
                $return = $this->createJson(1, null, json_encode($articleList));
            } else {
                $return = $this->createJson(0, "提交错误，用户不存在", null);
            }
        } else {
            $return = $this->createJson(0, "您未传递开发者Token", null);
        }
        return json($return);
    }

    //公众日记读取API
    public function getPublicArticle()
    {
        $request = Request::instance();
        $token_post = $request->param('token');
        $userToken = $request->param('usertoken');
        $articleid = $request->param('articleid');
        $tokenid = $this->checkToken($token_post);
        $this->createAPILog("*getArticle***|token:" . $token_post . "|userToken" . $userToken);
        if ($tokenid) {
            $uid = Db::table('nkbh_devselfuser')->field('id,username')->where('usertoken', $userToken)->select();
            if ($uid) {
                $temp['id'] = $articleid;
                $temp['status'] = 1;
                $article = Db::table('nkbh_userarticle')->where($temp)->select();
                foreach ($article as $k => $v) {
                    $username = Db::table('nkbh_devselfuser')->field('username')->where('id', $v['uid'])->find();
                    $article[$k]['username'] = $username['username'];
                }
                if ($article) {
                    $return = $this->createJson(1, "", json_encode($article));
                } else {
                    $return = $this->createJson(0, '文章不存在', null);
                }
            } else {
                $return = $this->createJson(0, "提交错误，用户不存在", null);
            }
        } else {
            $return = $this->createJson(0, "您未传递开发者Token", null);
        }
        return json($return);
    }

    //记录访问Log方法
    private function createLog($data)
    {
        $log = new M_Log();
        $log->tokenLog($data);
        return true;
    }

    //记录API访问日志方法
    private function createAPILog($data)
    {
        $log = new M_Log();
        $log->APILog($data);
        return true;
    }

    //验证开发token方法
    private function checkToken($data)
    {
        $token = Db::table('nkbh_devtoken')->where('token', $data)->select();
        if ($token) {
            $return = $tokenid = $token[0]['id'];
            return $return;
        } else {
            return false;
        }
    }

    //验证用户Token方法
    private function checkUserToken($data)
    {
        $token = Db::table('nkbh_devselfuser')->where('usertoken', $data)->select();
        if ($token) {
            if ($token[0]['date'] < time()) {
                //已经过期的用户Token
                return 1;
            } else {
                //未过期的用户Token
                return 2;
            }
        } else {
            return 0;
        }
    }

    //格式化返回值方法
    private function createJson($status, $message, $data)
    {
        $return = array(
            "status" => $status,
            "message" => $message,
            "data" => $data
        );
        return $return;
    }
}
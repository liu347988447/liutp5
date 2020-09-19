<?php


namespace app\app\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Config;

class Base extends Controller
{
    protected function _initialize()
    {
        $this->setheader();
    }

    public function index(){
        echo 'base-api';
    }

    /**
     *  公共方法调用
     * 跨域解决
     */
    public function setheader()
    {
        // 设置能访问的域名
        $originarr = Config::get('auto_url');
        // 获取当前跨域域名
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        if (in_array($origin, $originarr)) {
            // 允许 $originarr 数组内的 域名跨域访问
            header('Access-Control-Allow-Origin:' . $origin);
            // 响应类型
            header('Access-Control-Allow-Methods:POST,GET');
            // 带 cookie 的跨域访问
            header('Access-Control-Allow-Credentials: true');
            // 响应头设置
            header('Access-Control-Allow-Headers:x-requested-with,Content-Type,X-CSRF-Token');
        }
//        echo json_encode($originarr);
    }

    //生成token
    public function creat_token(){
        $token = md5(mt_rand('111111','999999').time());
        return $token;
    }

    //判断用户登录状态
    public function is_login(){
        $token = trim($_POST['token']);
        $mid = Db::name('token')->where("token",'=',$token)->value('mid');

        if ($mid>0){
            return $mid;
        }else{
            ajaxmsg('非法数据',0);
        }
    }
}
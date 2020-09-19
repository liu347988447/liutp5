<?php

namespace app\app\controller;

use think\Request;
use think\Db;
class Member extends Base{

    public function index()
    {
        $data['mobile'] = '18584441447';
        $count = Db::name('member')->where('mobile','=',$data['mobile'])->count();
        echo $count;
    }
    //用户注册接口
    public function reg(){

        $data['mobile'] = trim($_POST['mobile']);
        $data['mobile_bind'] = 1;
        $data['password'] = md5(trim($_POST['password']));
        $data['created_at'] = time();

        $code = trim($_POST['code']); //验证码验证

        $count = Db::name('member')->where('mobile','=',$data['mobile'])->count();

        if ($count>0){
            ajaxmsg('手机号也被占用',0);
        }else{
            $res = Db::name('member')->insertGetId($data);

            if ($res){
                ajaxmsg('注册成功，请登录',1);
            }else{
                ajaxmsg('注册失败',0);
            }
        }

    }

    //用户登录接口
    public function login(){
        $mobile = trim($_POST['mobile']);
        $password = md5(trim($_POST['password']));
        $deviceId = trim($_POST['deviseid']);

        $info = Db::name('member')->where("mobile='{$mobile}' and password = '{$password}'")->find();
        if ($info){

            $data['token'] = $this->creat_token();
            $data['mid'] = $info['id'];
            $data['deviceid'] = $deviceId;

            //查询是否登录，存在token
            $res = Db::name('token')->where("mid = {$data['mid']}")->find();
            if (res){
                Db::name('token')->where("mid = {$data['mid']}")->update(array('token'=>$data['token']));
            }else{
                Db::name('token')->insertGetId($data);
            }

            $info['token'] = $data['token'];
            ajaxmsg('登录成功',1,$info);

        }else{
            ajaxmsg('用户或密码错误！',0);
        }
    }


}
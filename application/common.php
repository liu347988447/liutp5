<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------

// 应用公共文件

use think\Db;

/*
//api数据返回接口
msg 返回提示
status  返回状态
data 数据
*/
function ajaxmsg($msg = "",$status = 1,$data = "",$errcode = ''){
    $json['msg'] = $msg;
    $json['status'] = $status;
    $json['data'] = $data;
    if ($errcode){
        $json['errcode'] = $errcode;
    }
    echo json_encode($json,true);
    exit;

}
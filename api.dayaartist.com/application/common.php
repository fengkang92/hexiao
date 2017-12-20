<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

	/**
     * 输入json数据
     */
    function JsonOutPut( $code = 0 , $message = '', $data = array()){
        //拼装数据
        $arr = array();

        //失败的状态码
        $arr['code'] = $code;

        //失败的提示信息
        $arr['message'] = $message;

        //失败返回的错误数据
        $arr['data'] = $data;

        //返回的JSON数据
        $json_str = json_encode( $arr );

        echo $json_str;
        exit;
    }
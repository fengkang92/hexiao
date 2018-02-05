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

    /**   
     * @desc 根据两点间的经纬度计算距离  
     * @param float $lat 纬度值  
     * @param float $lng 经度值  
    */   
    function getDistance($lat1, $lng1, $lat2, $lng2){   
        $earthRadius = 6367000; //approximate radius of earth in meters   
        $lat1 = ($lat1 * pi() ) / 180;   
        $lng1 = ($lng1 * pi() ) / 180;   
        $lat2 = ($lat2 * pi() ) / 180;   
        $lng2 = ($lng2 * pi() ) / 180;   
        $calcLongitude = $lng2 - $lng1;   
        $calcLatitude = $lat2 - $lat1;   
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);   
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));   
        $calculatedDistance = $earthRadius * $stepTwo;   
        return round($calculatedDistance);   
    }  

    /**
 * 求两个已知经纬度之间的距离,单位为米
 * 
 * @param lng1 $ ,lng2 经度
 * @param lat1 $ ,lat2 纬度
 * @return float 距离，单位米
 * @author www.Alixixi.com 
 */
function getdistances($lng1, $lat1, $lng2, $lat2) {
    // 将角度转为狐度
    $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);
    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
    return $s;
}  
 
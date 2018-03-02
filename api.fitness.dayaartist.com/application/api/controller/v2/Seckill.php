<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/26
 * Time: 14:15
 */

namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;
use think\Controller;
use app\api\model\TySeckill as SeckillModel;
use app\api\model\TyImg as ImgModel;
use app\api\model\TyCourseArrange as CourseArrange;

class Seckill extends Controller
{   
    /**
     * 
     * @return \think\Paginator
     * @throws ThemeExceptio
     */
    public function seckillList()
    {
        $time = date('H:i',time());
        if ($time < '12:00') {
            $time = '10:00-11:00';
            $start_time = '10:00';
            $end_time = '11:00';
        }else{
            $time = '18:00-19:00';
            $start_time = '18:00';
            $end_time = '19:00';
        }

        $seckillList = CourseArrange::getSeckillList($time);
        //print_r($seckillList->toArray());die;

        $seckillListData = array();
        $seckillListData['start_time'] = $start_time;
        $seckillListData['end_time'] = $end_time;
        // print_r($data->toArray());die;
        foreach ($seckillList as $key => $v) {
            $courseImg = ImgModel::getOneImg($v['course']['main_img_id']); //课程图片

            $seckillListData[$key] = array(
                'course_img' => $courseImg['img_url'],
                'course_name' => $v['course']['name'],
                'venue_name' => $v['venue']['name'],
                'price' => $v['course']['discount_price'],
                'seckill_price' => $v['seckill_price'],
                'date' => date('Y.m.d',$v['start_time']).' '.date('H:i',$v['start_time']).'-'.date('H:i',$v['end_time']),
            );
        }
        //print_r($seckillListData);die;
        return $seckillListData;
    }
}
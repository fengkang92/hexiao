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
        $data = SeckillModel::seckillList();

        $seckillListData = array();
        // print_r($data->toArray());die;
        foreach ($data as $key => $v) {
            $seckill = CourseArrange::getCourseTimeData($v['time_id']);
            $courseImg = ImgModel::getOneImg($seckill['course']['main_img_id']); //课程图片

            $status = 2;
            if ($data[$key]['start_time'] < time() && $data[$key]['end_time'] > time()) {
                $status = 1;
            }

            $seckillListData[$key] = array(
                'course_img' => $courseImg['img_url'],
                'course_name' => $seckill['course']['name'],
                'venue_name' => $seckill['venue']['name'],
                'price' => $seckill['course']['discount_price'],
                'seckill_price' => $v['seckill_price'],
                'date' => date('Y.m.d',$seckill['start_time']).' '.date('H:i',$seckill['start_time']).'-'.date('H:i',$seckill['end_time']),
                'status' => $status
            );
        }
        return $seckillListData;
    }
}
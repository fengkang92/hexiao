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
use app\api\model\TyVenueBranch as venueBranch;
use app\api\model\TyCourseArrange as CourseArrange;
use app\api\model\TyImg as ImgModel;
use app\api\model\TyCourse as CourseModel;
use app\api\model\TyType as TypeModel;

class Course extends Controller
{   
    /**
     * 课程安排
     * @param int $id 场馆分店ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function courseTimeList($id)
    {

      (new IDMustBePositiveInt())->goCheck();
        

        $start_date = date('Y-m-d', strtotime('-1 days'));
        $end_date = date('Y-m-d', strtotime('+7 days'));

        $TimeInfo = array();

        $CourseTime = CourseArrange::CourseTimeList($id,$start_date,$end_date); //课程时间列表
        
        if (empty($CourseTime)) {
            return [
                'code' => 404,
                'msg' => '暂无课程'
            ];
        }else{
            $CourseTime = $CourseTime->toArray();
        }

        /*echo '<pre>';
        print_r($CourseTime);die;*/
        $Venue = venueBranch::VenueDetails($id);   //场馆信息

        $venueImg = ImgModel::getManyImg($Venue['img_id']); //场馆图片
        //$courseImg = ImgModel::getOneImg($Venue['logo_id']); //场馆图片

        foreach ($venueImg as $key => $v) {
           $TimeInfo['img'][] = $v['img_url'];
        }

        //$weekarray=array("日","一","二","三","四","五","六");
        $date = date('Y-m-d');
        $TimeInfo['dates'] = array();
        foreach ($CourseTime as $key => $v) {
            if ($v['dates'] != $date) {
                $TimeInfo['time'][$date] = '';
            }

            $courseImg = ImgModel::getOneImg($v['course']['main_img_id']); //课程图片
            
            $TimeInfo['time'][$v['dates']][] = array('time_id'=>$v['id'],'course_img'=>$courseImg['img_url'],'course_name'=>$v['course']['name'],'teacher_name'=>$v['teacher']['name'],'date'=>$v['dates'],'time'=>date('H:i',$v['start_time']).'-'.date('H:i',$v['end_time']),'price'=>$v['course']['price']);
            $date = date("Y-m-d",strtotime("+1 day",strtotime($date)));

            
            /*if (!in_array($v['dates'], $TimeInfo['dates'])) {
                $TimeInfo['dates'][] = $v['dates'];
            }*/
            
        }
        /*echo '<pre>';
        print_r($TimeInfo);die;*/
        $dates = date('Y-m-d');
        for ($i=0; $i < 7; $i++) { 
            if (!isset($TimeInfo['time'][$dates])) {
                $TimeInfo['time'][$dates] = '';
            }
            $dates = date("Y-m-d",strtotime("+1 day",strtotime($dates)));
        }

        $TimeInfo['time'] = array_values($TimeInfo['time']);
        /*echo '<pre>';
        print_r($TimeInfo);die;*/
        return $TimeInfo;

    }

    /**
     * 预约课程详情
     * @param int $id 时间ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function reservedCourseDetails($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $course = CourseArrange::getCourseTime($id);
        if (empty($course)) {
            return [
                'code' => 400,
                'msg' => '参数异常'
            ];
        }else{
           $course = $course->toArray(); 
        }
        //print_r($course);die;
        $course_img = ImgModel::getManyImg($course['course']['img_id']);
        
        foreach ($course_img as $key => $value) {
            $CourseImg[] = $value['img_url'];
        }

        $courseData = array(
            'course_id'=>$course['course']['id'],
            'teacher_id'=>$course['teacher']['id'],
            'venue_id'=>$course['venue']['id'],
            'course_img'=>$CourseImg,
            'course_name'=>$course['course']['name'],
            'venue_name'=>$course['venue']['name'],
            'price'=>$course['course']['price'],
            'discount_price' =>$course['course']['discount_price'],
            'time' => $course['dates'].' '.date('H:i',$course['start_time']).'-'.date('H:i',$course['end_time']),
            'address' => $course['venue']['address'],
            'teacher' => array('img'=>$course['teacher']['img'],'name'=>$course['teacher']['name'],'content'=>$course['teacher']['content']),
            'course_content' => $course['course']['content']
        );
        
        return $courseData;
    }

    /**
     * 课程推荐
     * @throws ThemeException
     */
    public function CourseHot()
    {
        $data = TypeModel::getCourseType();
        return $data;
    }
}
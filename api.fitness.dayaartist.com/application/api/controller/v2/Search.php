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
use app\api\model\TyCourse as CourseModel;
use app\api\model\TyCourseArrange as CourseArrange;
use app\api\model\TyImg as ImgModel;
use app\api\model\TyVenueBranch as VenueBranch;

class Search extends Controller
{   
    /**
     * 
     * @param int info 搜索内容
     * @param int typer 类型 1课程 2
     * @return \think\Paginator
     * @throws ThemeExceptio
     */
    public function getSearchInfo($type,$info,$longitude='',$latitude='')
    {
        if ($type == 1 || $type == 2) {
            if ($type == 1) {
                $course = CourseModel::searchCourseName($info);
            }else{
                $course = CourseModel::searchCourseType($info);
            }
            
            if (empty($course)) {
                return [
                    'code' =>404,
                    'msg' => '搜索内容不存在',
                    'data' => ''
                ];
            }else{
                $course = $course->toArray();
            }
            
            $course_id = '';
            foreach ($course as $key => $v) {
                $course_id .= ','.$v['id'];
            }
            $course_id = trim($course_id,',');

            $courseTime = CourseArrange::searchCourseTime($course_id);

            $courseData = array();
            foreach ($courseTime as $key => $v) {
                $course_img = ImgModel::getOneImg($v['course']['main_img_id']);
                $courseData[] = array('time_id'=>$v['id'],'course_img'=>$course_img['img_url'],'course_name'=>$v['course']['name'],'teacher_name'=>$v['teacher']['name'],'date'=>date('Y-m-d',$v['start_time']),'time'=>date('H:i:s',$v['start_time']).'-'.date('H:i:s',$v['end_time']),'price'=>$v['course']['price'],'venue_key_word'=>$v['venue']['key_word']);
            }

            return [
                'code' => 200,
                'data' => $courseData
            ];
        }else{
            if ($type == 2) {
                $data = VenueBranch::searchVenueName($info);
            }else{
                $data = VenueBranch::searchVenueKeyWord($info);
            }

            if (empty($data)) {
                return [
                    'code' =>404,
                    'msg' => '搜索内容不存在',
                    'data' => ''
                ];
            }else{
                $data = $data->toArray();
            }

            foreach ($data as $key => $v) {
                $distance = getdistances($longitude,$latitude,$v['longitude'],$v['latitude']);
                $data[$key]['distance'] = round($distance/1000,2).'km';
                $main_img = ImgModel::getOneImg($v['main_img_id']);
                $logo_img = ImgModel::getOneImg($v['logo_id']);
                $data[$key]['main_img'] = $main_img['img_url'];
                $data[$key]['log_img'] = $logo_img['img_url'];
            }

            sortArrByOneField($data,'distance',false);
            /*echo '<pre>';
            print_r($data);die;*/
            return [
                'code' => 200,
                'data' => $data
            ];
        }
    }
}
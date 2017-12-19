<?php
/**
 * Created by 七月.
 * User: 七月
 * Date: 2017/2/15
 * Time: 1:00
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\api\model\BoxCoursePlan;
use app\api\model\BoxCourseService;
use think\Controller;
use app\lib\exception\BaseException;
class Course extends Controller
{
    /**
     * 获取某分类下全部课程
     * @param int $id 盒子id号
     * @param int $page
     * @param int $size
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getByCategoryCurriculum($id,$page = 1, $size = 15)
    {
        (new IDMustBePositiveInt())->goCheck();
        (new PagingParameter())->goCheck();
        //所有课程信息
        $curriculumData = BoxCoursePlan::getByCategoryCurr($id, $page, $size);
        if (!$curriculumData) {
            throw new BaseException([
                'code' => 404,
                'msg' => '课程列表为空',
                'errorCode' => 70000
            ]);
        }
		$data = $curriculumData->toArray();
        
        /*//剔除没有老师课程
        foreach ($data['data'] as $key => $v) {
            if (empty($data['data'][$key]['teacher'])) {
                unset($data['data'][$key]);
            }
        }*/

        //课程下最低价格
        $data = BoxCourseService::getByCourseMinPrice($data);

        return [
            'current_page' => $curriculumData->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 获取某课程详情课程
     * @param int $id 
     * @param int $minPrice 课程最低价
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getCurriculumData($id,$minPrice)
    {
        (new IDMustBePositiveInt())->goCheck();
        if ($id < 1) {
            throw new BaseException([
                'code' => 404,
                'msg' => '价格参数有误',
                'errorCode' => 10006
            ]);
        }
        //课程详情
        $CurriculumData = BoxCoursePlan::getCurrData($id);

        if (empty($CurriculumData)) {
            throw new BaseException([
                'code' => 404,
                'msg' => '暂无数据',
                'errorCode' => 70001
            ]);
        }

        $CurriculumData['minPrice'] = $minPrice;
        $CurriculumData['activity_time'] = '';
        return $CurriculumData;
    }

    /**
     * 预约信息
     * @param int $id 课程ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getReserve($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        //预约所需要的数据
        $teacherData = BoxCourseService::getCourseTeacher($id);
        //print_r($teacherData);die;
        if (empty($teacherData)) {
            throw new BaseException([
                'code' => 404,
                'msg' => '暂无老师，请选择其他课程',
                'errorCode' => 70006
            ]);
        }

        $course_info = array();
        foreach ($teacherData as $key => $val) {
            if (empty($val['curr_time'])) {  //去除没有上课时间的老师

                unset($teacherData[$key]);

            }else{
                $course_info['course_name'] = $teacherData[$key]['course_plan']['server_name'];
                $course_info['discribe'] = $teacherData[$key]['course_plan']['discribe'];
                $course_info['main_img_url'] = $teacherData[$key]['course_plan']['main_img_url'];

                foreach ($val['curr_time'] as $k => $v) {
                    $date = date('Y年m月d日',$v['start_time']);
                    $time = date('H:i',$v['start_time']).'--'.date('H:i',$v['end_time']);
                    //$course_info[$date][] = $time;

                    $course_info['data'][$date][$time][] = array('teacher'=>$teacherData[$key]['server_name'],'stock'=>$v['stock'],'time_id'=>$v['id'],'discount'=>$teacherData[$key]['discount']);
                }
            }
        }
        //print_r($course_info);die;
        return $course_info;
    }
}
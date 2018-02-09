<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class TyCourse extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    /**
     * 获取课程详情
     * @param $id 课程ID
     * @return \think\Paginator
     */
    public static function VenueDetails($id)
    {
        //$CourseTime = self::where('venue_branch_id',$id)->whereTime('dates','between',['2018-02-05','2018-02-11'])->select();
        $CourseTime = self::where('id',$id)->find()->toArray();
        return $CourseTime;
    }

    /**
     * 搜索课程（名称）
     * @param $info 搜索内容
     * @return \think\Paginator
     */
    public static function searchCourseName($info)
    {
        $course = self::where('name','like',"%{$info}%")->select();
        return $course;
    }

    /**
     * 搜索课程（类型）
     * @param $info 搜索内容
     * @return \think\Paginator
     */
    public static function searchCourseType($id)
    {
        $course = self::where('type_id',$id)->select();
        return $course;
    }
    
}
<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class Ty_course_arrange extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    //关联课程
    public function course()
    {
        return $this->hasOne('Ty_course','course_id','id');
    }

    //老师
    public function teacher()
    {
        return $this->hasOne('Ty_teacher','teacher_id','id');
    }

    /**
     * 获取课程时间列表
     * @param $sid 场馆ID
     * @param $start_date 开始时间
     * @param $end_date   结束时间
     * @return \think\Paginator
     */
    public static function CourseTimeList($id,$start_date,$end_date)
    {
        //$CourseTime = self::where('venue_branch_id',$id)->whereTime('dates','between',['2018-02-05','2018-02-11'])->select();
        $CourseTime = self::with(['course','teacher'])->where('venue_branch_id',$id)->where('dates','>',$start_date)->where('dates','<',$end_date)->select();
    	return $CourseTime;
    }
}
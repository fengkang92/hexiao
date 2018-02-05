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
        $CourseTime = self::where('venue_branch_id',$id)->where('dates','>',$start_date)->where('dates','<',$end_date)->select();
    	return $CourseTime;
    }
}
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
     * @param $sid 盒子ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function CourseTimeList($id,$dates)
    {
        $dates = intval($dates) - 1;
        self::where('id',$id)->where('dates','<', $dates)->where('end_time','>',time())->find();
    	$venue = self::where()->select()->toArray();
    	return $venue;
    }
}
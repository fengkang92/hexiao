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
}
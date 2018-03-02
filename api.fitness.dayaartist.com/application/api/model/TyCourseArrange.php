<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class TyCourseArrange extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    //关联课程
    public function course()
    {
        return $this->belongsTo('TyCourse','course_id','id');
    }

    //关联老师
    public function teacher()
    {
        return $this->belongsTo('TyTeacher','teacher_id','id');
    }

    //关联场馆
    public function venue()
    {
        return $this->belongsTo('TyVenueBranch','venue_branch_id','id');
    }

    /**
     * 获取预约课程详情
     * @param $id 时间ID
     * @param $end_date   结束时间
     * @return \think\Paginator
     */
    public static function getCourseTime($id)
    {
        //$CourseTime = self::where('venue_branch_id',$id)->whereTime('dates','between',['2018-02-05','2018-02-11'])->select();
        $Course = self::with(['course','teacher','venue'])->where('venue_branch_id',$id)->find();
        return $Course;
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
        $CourseTimeL = self::with(['course','teacher'])->where('venue_branch_id',$id)->where('dates','>',$start_date)->where('dates','<',$end_date)->select();
    	return $CourseTimeL;
    }

    /**
     * 获取搜索课程时间
     * @param $sid 场馆ID
     * @return \think\Paginator
     */
    public static function searchCourseTime($id)
    {   
        $where['course_id'] = array('in',$id);
        //$CourseTime = self::where('venue_branch_id',$id)->whereTime('dates','between',['2018-02-05','2018-02-11'])->select();
        $CourseTimeL = self::with(['course','teacher','venue'])->where($where)->where('start_time','>',time())->select();
        return $CourseTimeL;
    }

    /**
     * 获取订单课程信息
     * @param $oPIDs
     * @return array
     */
    public static function getCourseWithIds($oPIDs)
    {
        $products = self::with(['course','teacher','venue'])->where('id','in',$oPIDs)->select()->toArray();
        return $products;
    }

    /**
     * 获取预约课程详情
     * @param $id 时间ID
     * @param $end_date   结束时间
     * @return \think\Paginator
     */
    public static function getCourseTimeData($id)
    {
        //$CourseTime = self::where('venue_branch_id',$id)->whereTime('dates','between',['2018-02-05','2018-02-11'])->select();
        $Course = self::with(['course','teacher','venue'])->where('id',$id)->find();
        return $Course;
    }

    public static function getSeckillList($time)
    {
        $data = self::with(['course','venue'])->where('start_time','>',time())->where('seckill_time',$time)->where('is_seckill',1)->select();
        return $data;
    }
}
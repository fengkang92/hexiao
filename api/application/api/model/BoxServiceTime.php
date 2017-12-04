<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;


class BoxServiceTime extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['delete_time', 'create_time', 'update_time'];

    public function service()
    {
        return $this->belongsTo('BoxCourseService', 'service_id', 'id');
    }

    public static function getServiceWithIds($oPIDs)
    {
        $products = self::alias('time')
            ->join('box_course_service service','service.id = time.service_id','left')
            ->join('box_course_plan plan','plan.id = service.course_plan_id','left')
            ->field('time.id,time.service_id,time.stock,service.sid,service.supplier_id,service.discount as price,service.main_img_url,service.server_name as sname,plan.server_name as pname')
            ->where('time.id','in',$oPIDs)
            ->select()
            ->toArray();
        return $products;
    }

    public static function getBytimeSection($time)
    {
        $data = self::where('id',$time)->where('start_time - 900','<', time())->where('end_time','>',time())->find();
        if ($data) {
            return $data;
        }else{
            return null;
        }
    }

//////////////////////////////////////Booking/////////////////////////////////

    /**
     * 获取某盒子下比预约时间小的第一个时间
     * @param $box_id 盒子ID
     * @param $start_time 预约开始时间
     * @return \think\Paginator
     */ 
    public static function getCourseFrontTime($box_id,$start_time)
    {
        $now_time = strtotime(date('Y-m-d'));
        $data = self::where('sid',$box_id)->where('start_time','>',$now_time)->where('start_time','<', $start_time)->where('status',2)->order('start_time desc')->limit(1)->find();
        return $data;
    }

    /**
     * 获取某盒子下比预约时间大的第一个时间
     * @param $box_id 盒子ID
     * @param $start_time 预约开始时间
     * @return \think\Paginator
     */ 
    public static function getCourseAfterTime($box_id,$start_time)
    {
        $end_time = strtotime(date('Y-m-d 23:59:59'));
        $data = self::where('sid',$box_id)->where('start_time','>',$start_time)->where('start_time','<', $end_time)->where('status',2)->order('start_time asc')->limit(1)->find();
        return $data;
    }

    /**
     * 获取库存
     * @param $box_id 盒子ID
     * @param $start_time 预约开始时间
     * @return \think\Paginator
     */
    public static function getStock($teacher_id,$start_time,$end_time)
    {
        $where = array('service_id'=>$teacher_id,'start_time'=>$start_time,'end_time'=>$end_time);
        $time_data = self::where($where)->find();
        return $time_data;
    }
}
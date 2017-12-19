<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 16:45
 */

namespace app\api\model;


class BoxCoursePlan extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['delete_time', 'plan_type','create_time', 'update_time'];

    //老师联表
    public function teacher()
    {
        return $this->hasMany('box_course_service', 'course_plan_id', 'id');
    }

    //规格联表
    public function property()
    {
        return $this->hasMany('product_property', 'course_plan_id', 'id');
    }
    //图片前缀
    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
    //图片前缀
    public function getHomeImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    /**
     * 获取某分类下课程
     * @param $course_id
     * @param int $page
     * @param int $size
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getByCategoryCurr($course_id, $page = 1, $size = 15)
    {
        $currData = self::where('sid',$course_id)->select()->toArray();
        if (empty($currData)) {
            return $currData;
        }

        $pagingData = self::with('teacher')
                      ->where('sid', '=', $course_id)
                      ->where('status',1)
    		          ->order('id desc')
                      ->paginate($size, true, ['page' => $page]);

        return $pagingData;
	}

    /**
     * 获取某课程详情
     * @param $course_plan_id 课程ID
     * @param bool $paginate 
     * @return \think\Paginator
     */
    public static function getCurrData($course_plan_id)
    {
        $CurrData = BoxCoursePlan::find($course_plan_id);
        if (empty($CurrData)) {
            return $CurrData;
        }

        $CurrData = BoxCoursePlan::with(['teacher','property'])
                                 ->find($course_plan_id)
                                 ->toArray();
        return $CurrData;
    }

    /**
     * 获取热销课程
     * @param bool $paginate 
     * @return \think\Paginator
     */
    public static function getHotCoursePlan($count)
    {
        $hot_curr = self::where('hot',1)->where('status',1)->limit($count)->select()->toArray();
        return $hot_curr;
    }

 /////////////////////////////////////////booking///////////////////////////////

    /**
     * 获取课程ID
     * @param $supplier_id 供应商ID
     * @param $course_name 课程名称
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getCourseId($supplier_id,$course_name)
    {
        $where = array('suppiler_id'=>$supplier_id,'server_name'=>$course_name);

        $course = self::where($where)->field('id,status')->find();
        return $course;
    }
}
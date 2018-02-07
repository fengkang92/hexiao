<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;


class BoxCourse extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    /**
     * 获取盒子信息
     * @param $sid 盒子ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getOneCourse($sid)
    {
    	$where = array('sid'=>$sid,'status'=>1);
    	$course = self::where('sid',$sid)->find()->toArray();
    	return $course;
    }

 ////////////////////////////////////////////////booking////////////////////////////
    /**
     * 获取盒子信息
     * @param $sid 盒子ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getCourseRelationship($sid)
    {
        $course = self::where('sid',$sid)->find();
        return $course;
    }
}
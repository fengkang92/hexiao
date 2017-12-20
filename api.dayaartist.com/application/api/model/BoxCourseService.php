<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;


class BoxCourseService extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['delete_time','create_time', 'update_time'];

    //关联课程时间表
    public function currTime()
    {
        return $this->hasMany('box_service_time','service_id','id')->where('status',1)->where('start_time','>',time());
    }

    //关联课程表
    public function coursePlan()
    {
        return $this->hasOne('box_course_plan','id','course_plan_id');
    }

    //关联盒子
    public function course()
    {
        return $this->hasOne('box_course','sid','sid');
    }

    /**
     * 获取分类下课程最低价
     * @param $course_id
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getByCourseMinPrice($data)
    {
        foreach ($data['data'] as $key => $v) {
            $minPrice = self::where('course_plan_id',$v['id'])->min('discount');
            $data['data'][$key]['minPrice'] = $minPrice;
            $data['data'][$key]['tag'] = explode('|',$v['tag']);
            unset($data['data'][$key]['teacher']);
        }
        return $data;
	}

    /**
     * 获取某课程下所有老师
     * @param $course_plan_id
     * @param bool $paginate
     * @return \think\Paginator
     */ 
    public static function getCourseTeacher($course_plan_id){
        //echo time();die;
        $teacherData = self::with(['currTime','coursePlan'])->where('course_plan_id', '=', $course_plan_id)->where('stauts',1)->select()->toArray();

        return $teacherData;
    }

    /**
     * 获取一个老师信息
     * @param $course_plan_id
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getOneTeacher($name,$tel)
    {
        $where = array('server_name'=>$name,'tel'=>$tel,'stauts'=>1);
        $teacher = self::where($where)->find();
        return $teacher;
    } 


////////////////////////////////////booking//////////////////////

    /**
     * 获取老师ID
     * @param $course_plan_id 课程ID
     * @param $teacher_tel    老师ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getTeacherId($course_plan_id,$teacher_tel)
    {
        $where = array('course_plan_id'=>$course_plan_id,'tel'=>$teacher_tel);
        $teacher = self::where($where)->field('id,stauts,sid')->find();
        return $teacher;
    } 

}
<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class TyType extends BaseModel
{
    protected $autoWriteTimestamp = true;

    /**
     * 获取课程时间列表
     * @return \think\Paginator
     */
    public static function getCourseType()
    {
        $CourseType = self::where('status',1)->select();
    	return $CourseType;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class Ty_img extends BaseModel
{
    protected $autoWriteTimestamp = true;
    //protected $hidden = ['create_time','update_time','main_img_id','img_id','logo_id'];

    /**
     * 获取课程时间列表
     * @param $sid 盒子ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getOneImg($id)
    {
    	$main_img = self::where('id',$id)->find()->toArray();
    	return $main_img;
    }
}
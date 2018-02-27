<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class TyImg extends BaseModel
{
    protected $autoWriteTimestamp = true;
    //protected $hidden = ['create_time','update_time','main_img_id','img_id','logo_id'];

    //图片前缀
    public function getImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    /**
     * 获取一张图片
     * @param $id 盒子ID
     * @return \think\Paginator
     */
    public static function getOneImg($id)
    {
    	$main_img = self::where('id',$id)->find();
        //print_r($main_img);die;
    	return $main_img;
    }

    /**
     * 获取多张图片
     * @param $id 多个id
     * @return \think\Paginator
     */
    public static function getManyImg($id)
    {
        $where['id'] = array('in',$id);
        $main_img = self::where($where)->select()->toArray();
        return $main_img;
    }
}
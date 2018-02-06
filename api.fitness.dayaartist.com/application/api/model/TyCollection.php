<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class TyCollection extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    //关联场馆
    public function venue()
    {
        return $this->belongsTo('TyVenueBranch','venue_branch_id','id');
    }

    /**
     * 用户收藏列表
     * @param $id 用户ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getUserCollection($id)
    {
    	$where = array('user_id'=>$id,'status'=>1);
    	$collection = self::with('venue')->where($where)->select()->toArray();
    	return $collection;
    }

}
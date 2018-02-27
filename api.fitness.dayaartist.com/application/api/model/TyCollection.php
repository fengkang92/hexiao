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
     * 查询用户收藏
     * @param $uid 用户ID
     * @param $venue_id 场馆ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getUserCollect($uid,$venue_id)
    {
        $where = array('user_id'=>$uid,'venue_branch_id'=>$venue_id);
        $collection = self::where($where)->find();
        return $collection;
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
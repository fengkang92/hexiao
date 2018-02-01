<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class Ty_venue extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    /**
     * 获取盒子信息
     * @param $sid 盒子ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function VenueList()
    {
    	$venue = self::select()->toArray();
    	return $venue;
    }

    /**
     * 获取盒子信息
     * @param $sid 盒子ID
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function VenueDetails($id)
    {
        $where = array('id'=>$id,'status'=>1);
        $venueData = self::where('sid',$sid)->find();
        return $venueData;
    }
    
}
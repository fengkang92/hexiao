<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class TySeckill extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    //关联课程
    public function course()
    {
        return $this->belongsTo('TyCourse','course_id','id');
    }

    //关联场馆
    public function venue()
    {
        return $this->belongsTo('TyVenueBranch','venue_branch_id','id');
    }


    /**
     * 获取课程时间列表
     * @return \think\Paginator
     */
    public static function seckillList()
    {
        $SeckillList = self::where('start_time','>',time())->select();
    	return $SeckillList;
    }
}
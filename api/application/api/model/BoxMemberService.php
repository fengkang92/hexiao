<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;


class BoxMemberService extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['delete_time', 'create_time', 'update_time'];

    public static function checkUserTime($user_id,$time_id)
    {
        $user_time = self::where(['uid'=>$user_id,'service_time_id'=>$time_id])->find();
        return $user_time;
	}
}
<?php

namespace app\api\model;

class User extends BaseModel
{
    protected $autoWriteTimestamp = true;
//    protected $createTime = ;

    public function orders()
    {
        return $this->hasMany('Order', 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByOpenID($openid)
    {
        $user = User::where('openid', '=', $openid)
            ->find();
        return $user;
    }

    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByOneUser($id)
    {
        $user = User::where('id', '=', $id)
            ->field('avatarUrl,city,country,gender,language,nickName,province')
            ->find();
        return $user;
    }

    /**
     * 用添加用户信息
     */
    public static function saveUserInfo($id,$info)
    {
        $res = self::where('id',$id)->update($info);
        return $res;
    }
}

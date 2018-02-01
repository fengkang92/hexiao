<?php

namespace app\api\model;

class Adminuser extends BaseModel
{

    /**
     * 登陆验证
     * @param $name 账号
     * @param $pwd 密码
     * @return \think\Paginator
     */
    public static function checkUser($name)
    {
        $banner = self::where('name',$name)->find();
        return $banner;
    }
}

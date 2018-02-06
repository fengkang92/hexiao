<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class TyTeacher extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];

    //图片前缀
    public function getImgAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

}
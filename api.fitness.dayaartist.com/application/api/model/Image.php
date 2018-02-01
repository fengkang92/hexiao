<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['delete_time', 'id', 'from','update_time'];

    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}


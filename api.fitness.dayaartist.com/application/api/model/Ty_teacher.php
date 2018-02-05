<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;

class Ty_teacher extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time'];
}
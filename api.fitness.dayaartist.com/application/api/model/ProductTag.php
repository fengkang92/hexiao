<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/8/8
 * Time: 15:45
 */

namespace app\api\model;


class ProductTag extends BaseModel
{
    protected $hidden = ['id','product_id','delete_time','update_time'];
}
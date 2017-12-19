<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/8/18
 * Time: 16:18
 */

namespace app\api\model;


class ProductSize extends BaseModel
{
    protected $hidden = ['id', 'product_id','delete_time', 'update_time'];
}
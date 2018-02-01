<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/8/22
 * Time: 11:00
 */

namespace app\api\model;


class ProductTime extends BaseModel
{
    protected $hidden = ['id', 'product_id', 'delete_time', 'update_time'];
}
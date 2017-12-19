<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/8/21
 * Time: 18:30
 */

namespace app\api\model;


class ProductFeature extends BaseModel
{
    protected $hidden = ['id', 'product_id', 'delete_time','update_time'];
}
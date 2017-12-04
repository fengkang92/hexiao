<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 03/10/2017
 * Time: 9:28 PM
 */

namespace app\common\model;


use think\Model;

class City extends Model
{
    public function getNormalCitysByParentId($parentId=0){
        $data = [
            'status' => 1,
            'parent_id' => $parentId,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

}
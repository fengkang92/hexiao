<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;

    public function add($data)
    {
        $data['status'] = 1;
//        $data['create_time'] = time();
        return $this->save($data);
    }

    public function getNormalFirstCategory()
    {
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)->order($order)->select();
    }

    public function getFirstCategorys($parentId = 0)
    {
        $data = [
            'status' => ['neq', -1],
//            'parent_id' => $parentId,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $result = $this->where($data)->order($order)->paginate();
//        echo $this->getLastsql();

        return $result;
    }

}
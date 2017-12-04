<?php

namespace app\api\model;

use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\OrderException;
use think\Model;

class Order extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

    public function getSnapItemsAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode(($value));
    }

    public static function getSummaryByUser($uid, $page = 1, $size = 15)
    {
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData;
    }

    public static function getSummaryByPage($page = 1, $size = 20)
    {
        $pagingData = self::order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData;
    }

    public function products()
    {
        return $this->belongsToMany('Product', 'order_product', 'product_id', 'order_id');
    }

    public function serviceTime()
    {
        return $this->belongsTo('BoxServiceTime', 'time_id', 'id');
    }

    public static function getOrderDetail($id, $uid)
    {
        $orderDetail = self::get($id);
        if ($orderDetail['user_id'] == $uid) {
            if ($orderDetail['time_id'] !== null) {
                $orderDetail = self::with('serviceTime')
                    ->where('id', '=', $id)
                    ->find();
                $orderDetail['data'] = date('y年m月d日', $orderDetail['serviceTime']['start_time']);
                $orderDetail['time'] = date('H:I', $orderDetail['serviceTime']['start_time']) . '--' . date('h:i', $orderDetail['serviceTime']['end_time']);
                return $orderDetail = $orderDetail->hidden(['prepay_id', 'service_time', 'serviceTime']);
            } else {
                return $orderDetail->hidden(['prepay_id']);
            }

        }


    }
}

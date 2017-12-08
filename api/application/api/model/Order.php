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

    public function getCodeImgAttr($value)
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

    public static function getSummaryByAdmin($admin_id, $page = 1, $size = 15)
    {
        $pagingData = self::where('admin_id', '=', $admin_id)
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
        if (!empty($orderDetail)) {
            if ($orderDetail['user_id'] == $uid) {
                return $orderDetail->hidden(['prepay_id']);
            }
        }else{
            return '';
        }
    }

    //查看订单状态
    public static function checkOrderStatus($order_no){
        $order_data = self::where('order_no',$order_no)->find();
        return $order_data;
    }

    //修改订单状态
    public static function uptOrderStatus($order_no,$status){
        $res = self::where('order_no',$order_no)->update(array('status',$status));
        return $res;
    }
}

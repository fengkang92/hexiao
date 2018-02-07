<?php

namespace app\api\model;

use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\OrderException;
use think\Model;

class Order extends BaseModel
{
    protected $hidden = ['delete_time'];
    protected $autoWriteTimestamp = true;

    public function getSnapItemsAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public function getCodeImgAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
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

    public static function getOrderDetail($id,$uid)
    {
        $orderDetail = self::get($id);
//        print_r($orderDetail);die();
        if (!empty($orderDetail)) {
            if ($orderDetail['user_id'] == $uid) {
            return $orderDetail->hidden(['prepay_id']);
            }
        }else{
            return '';
        }
    }

    public static function getOrderDetailByChecker($order_no)
    {
//        print_r($order_no);die();
        $orderDetail = self::where('order_no', '=', $order_no)->find();
//        print_r($orderDetail);die();
        if (!empty($orderDetail)) {
            return $orderDetail->hidden(['prepay_id']);
        } else {
            return '';
        }
    }

    //查看订单状态
    public static function checkOrderStatus($order_no)
    {
        $order_data = self::where('order_no', $order_no)->find();
//        print_r($order_data);die();
        return $order_data;
    }

    //修改订单状态
    public static function uptOrderStatus($order_no, $status,$admin_id)
    {
        $res = self::where('order_no', $order_no)->update(['status' => $status, 'admin_id' => $admin_id]);
        return $res;
    }
}

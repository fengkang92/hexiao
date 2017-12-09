<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/5/27
 * Time: 14:33
 */

namespace app\api\service;


use app\api\model\BoxServiceTime;
use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\api\model\Order as OrderModel;
use app\api\validate\OrderPlace;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
    // 订单的商品列表，也就是客户端传递过来的products参数
    protected $oProducts;

    // 真实的商品信息（包括库存量）
    protected $products;

    protected $uid;

    public function place($uid, $oProducts)
    {
        //oProducts和products 作对比
        // products从数据库中查询出来
        $this->oProducts = $oProducts;
//        print_r($oProducts);die();
        if ($oProducts[0]['type'] == 0) {
            $this->products = $this->getProductsByOrder($oProducts);
            $this->uid = $uid;
            $status = $this->getOrderStatus();
            if (!$status['pass']) {
                $status['order_id'] = -1;
                return $status;
            }

            //开始创建订单
            $orderSnap = $this->snapOrder($status);
            $order = $this->createOrder($orderSnap);
        } elseif ($oProducts[0]['type'] == 1) {
            $this->products = $this->getCourseByOrder($oProducts);
            $this->uid = $uid;
            $status = $this->getCourseOrderStatus();
            if (!$status['pass']) {
                $status['order_id'] = -1;
                return $status;
            }

            //开始创建订单
            $orderSnap = $this->snapCourseOrder($status);
            $order = $this->createCourseOrder($orderSnap);
        }
        $order['pass'] = true;
        return $order;
    }

    /**
     * 预约课程创建订单流程
     */
    private function createCourseOrder($snap)
    {
        Db::startTrans();
        try {
            //数据写入课程用户关系表
            $service = new \app\api\model\BoxMemberService();
            $service->service_time_id = $this->oProducts[0]['product_id'];
            $service->uid = $this->uid;
            $service->yname = $this->oProducts[0]['parameterA'];
            $service->ytel = $this->oProducts[0]['parameterB'];
            $service->save();

            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->supplier_id = $this->products[0]['supplier_id'];
            $order->sid = $this->products[0]['sid'];
            $order->service_id = $this->products[0]['service_id'];
            $order->time_id = $this->oProducts[0]['product_id'];
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->time = $service->id;
//            print_r($order);die();
            $order->save();
            $orderID = $order->id;
            $create_time = $order->create_time;


//数据写入商品订单关系表
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
                unset($p['parameterA']);
                unset($p['parameterB']);
                unset($p['type']);
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);

            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        } catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }

    // 生成订单快照
    private function snapCourseOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => ''
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapName'] = $this->products[0]['sname'].'-'.$this->products[0]['pname'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
//        print_r($snap);die();
        return $snap;
    }

//    检测课程库存量
    public function checkCourseOrderStock($orderID)
    {
        $oProducts = OrderProduct::where('order_id', '=', $orderID)
            ->select();
        $this->oProducts = $oProducts;

        $this->products = $this->getCourseByOrder($oProducts);
        $status = $this->getCourseOrderStatus();
        return $status;
    }

    private function getCourseOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getCourseStatus(
                $oProduct['product_id'], $oProduct['count'], $this->products
            );
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['counts'];

            array_push($status['pStatusArray'], $pStatus);
        }
//        print_r($status);die();
        return $status;
    }

    private function getCourseStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;

        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'counts' => 0,
            'price' => 0,
            'name' => '',
            'totalPrice' => 0,
            'main_img_url' => null
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            // 客户端传递的product_id有可能根本不存在
            throw new OrderException(
                [
                    'msg' => 'id为' . $oPID . '的预约商品不存在，创建订单失败'
                ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['sname'] . '-' . $product['pname'];
            $pStatus['counts'] = $oCount;
            $pStatus['price'] = $product['price'];
            $pStatus['main_img_url'] = $product['main_img_url'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
//        print_r($pStatus);die();
        return $pStatus;
    }

    // 根据订单信息查找真实的商品信息
    private function getCourseByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        $products = BoxServiceTime::getServiceWithIds($oPIDs);
//        print_r($products);die();
        return $products;
    }


    /**
     * 商品创建订单流程
     */
    private function createOrder($snap)
    {
        Db::startTrans();
        try {
            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->feature = $this->oProducts[0]['parameterA'];
            $order->express = $this->oProducts[0]['parameterB'];

            $order->save();

            $orderID = $order->id;
            $create_time = $order->create_time;

            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
                unset($p['parameterA']);
                unset($p['parameterB']);
                unset($p['type']);
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        } catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }

    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -3) . substr(microtime(), 2, 3) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

    // 生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => ''
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
//        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }

        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)
            ->find();
        if (!$userAddress) {
            throw new UserException(
                [
                    'msg' => '用户收货地址不存在，下单失败',
                    'errorCode' => 60001,
                ]);
        }
        return $userAddress->toArray();
    }

    public function checkOrderStock($orderID)
    {
        $oProducts = OrderProduct::where('order_id', '=', $orderID)
            ->select();
        $this->oProducts = $oProducts;

        $this->products = $this->getProductsByOrder($oProducts);
        $status = $this->getOrderStatus();
        return $status;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'], $oProduct['count'], $this->products
            );
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['counts'];

            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;

        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'counts' => 0,
            'price' => 0,
            'name' => '',
            'totalPrice' => 0,
            'main_img_url' => null
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            // 客户端传递的product_id有可能根本不存在
            throw new OrderException(
                [
                    'msg' => 'id为' . $oPID . '的商品不存在，创建订单失败'
                ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['counts'] = $oCount;
            $pStatus['price'] = $product['price'];
            $pStatus['main_img_url'] = $product['main_img_url'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }

        return $pStatus;
    }

    // 根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts)
    {
        //        foreach ($oProducts as $oProduct){
        //            //循环的查询数据库
        //        }
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }

    public function delivery($orderID, $jumpPage = '')
    {
        $order = OrderModel::where('id', '=', $orderID)
            ->find();
        if (!$order) {
            throw new OrderException();
        }
        if ($order->status != OrderStatusEnum::PAID) {
            throw new OrderException([
                'msg' => '还没付款呢，想干嘛？或者你已经更新过订单了，不要再刷了',
                'errorCode' => 80002,
                'code' => 403
            ]);
        }
        $order->status = OrderStatusEnum::DELIVERED;

        OrderModel::where('id', $orderID)->update(['status' => OrderStatusEnum::DELIVERED]);
        //$order->save();
        //            ->update(['status' => OrderStatusEnum::DELIVERED]);
        $message = new DeliveryMessage();
        return $message->sendDeliveryMessage($order, $jumpPage);
    }
}
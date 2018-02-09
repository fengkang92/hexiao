<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/22
 * Time: 21:52
 */

namespace app\api\controller\v2;

use app\api\controller\BaseController;
use app\api\model\BoxCourse;
use app\api\model\BoxServiceTime;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\api\service\Token;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;
use app\lib\exception\SuccessMessage;
use think\Controller;
use think\Db;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail'],
        'checkSuperScope' => ['only' => 'delivery,getSummary']
    ];

    /**
     * 下单
     * @url /order
     * @HTTP POST
     */
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = Token::getCurrentUid();
//        $uid = 1;
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

    /**
     * 用户获取订单详情
     * @param $id
     * @return static
     * @throws OrderException
     * @throws \app\lib\exception\ParameterException
     */
    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        //增加uid判断
        $uid = Token::getCurrentUid();
        $orderDetail = OrderModel::getOrderDetail($id, $uid);
        if (!$orderDetail) {
            throw new OrderException();
        }
//        print_r($orderDetail);die;
        return $orderDetail->toArray();
    }

    /**
     * 商户获取订单详情
     * @param $id
     * @return static
     * @throws OrderException
     * @throws \app\lib\exception\ParameterException
     */
    public function getDetailByChecker($order_no)
    {
//        (new IDMustBePositiveInt())->goCheck();
//        print_r($order_no);die();
        $orderDetail = OrderModel::getOrderDetailByChecker($order_no);
        if (!$orderDetail) {
            return [
                'code' => 400,
                'data' => '',
                'msg' => '订单不存在！'
            ];
        }
        return [
            'code' => 200,
            'data' => $orderDetail->toArray()
        ];
    }

    /**
     * 根据用户id分页获取订单列表（简要信息）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummaryByUser($page = 1, $size = 999, $admin_id = 0)
    {
        (new PagingParameter())->goCheck();
        if ($admin_id == 0) {
            $uid = Token::getCurrentUid();
            $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        } else {
            $pagingOrders = OrderModel::getSummaryByAdmin($admin_id, $page, $size);
        }
        if ($pagingOrders->isEmpty()) {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
//        $collection = collection($pagingOrders->items());
//        $data = $collection->hidden(['snap_items', 'snap_address'])
//            ->toArray();
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];

    }

    /**
     * 获取全部订单简要信息（分页）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummary($page = 1, $size = 999)
    {
        (new PagingParameter())->goCheck();
//        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByPage($page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];
    }

    public function delivery($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $order = new OrderService();
        $success = $order->delivery($id);
        if ($success) {
            return new SuccessMessage();
        }
    }

    /**
     * 根据订单号核销
     * @param $order_no
     * @param $status 1.待支付 2.已支付，待使用 3.已使用
     * @return array
     */
    public function checkOrderStatus($order_no, $status, $admin_id)
    {
        //echo 111;die;
        $order_data = OrderModel::checkOrderStatus($order_no);
//        print_r($order_data);die();
        if (empty($order_data)) {
            return [
                'code' => 404,
                'msg' => '订单不存在'
            ];
        } elseif ($order_data['user_id'] != 0) {
            $order_data = $order_data->toArray();
//        print_r($order_data);die();
            if ($order_data['status'] == $status) {
                return [
                    'code' => 201,
                    'msg' => '已经核销，不用重复操作！'
                ];
            }
            $res = OrderModel::uptOrderStatus($order_no, $status, $admin_id);
            if (empty($res)) {
                return [
                    'code' => 500,
                    'msg' => '服务器出错'
                ];
            }
            return [
                'code' => 200,
                'msg' => '核销成功！'
            ];
        } elseif ($order_data['user_id'] == 0) {
            return [
                'code' => 200,
                'msg' => '核销成功！'];
        }
    }

    /**
     * 生成赠票记录
     */
    public function generateOrder($num)
    {

        for ($i = 0; $i < $num; $i++) {
            //订单号
            $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
            $orderSn =
                $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -3) . substr(microtime(), 2, 3) . sprintf('%02d', rand(0, 99));

            //二维码
            $save_path = BASE_PATH . 'qrcode/';  //图片存储的绝对路径
            //echo $save_path;die;
            $web_path = 'http://' . $_SERVER['HTTP_HOST'] . '/qrcode/'; //图片在网页上显示的路径

            $qr_data = $orderSn;

            $qr_level = 'H';

            $qr_size = '10';

            $save_prefix = 'ZETA';

            $filename = createQRcode($save_path, $qr_data, $qr_level, $qr_size, $save_prefix);

            $img_path = '/qrcode/' . $filename;

            $data = array('order_no' => $orderSn, 'create_time' => time(), 'status' => 1, 'total_price' => 0, 'total_count' => 1, 'code_img' => $img_path, 'snap_name' => '华熙LIVE，五棵松灯光节（赠票）');

            Db::name('order')->insert($data);
        }
    }

    /**
     * 订单号取出
     */
    public function getOrder($num)
    {
        $data = Db::table('order')->order('id desc')->limit($num)->column('order_no');
        foreach ($data as $value){
            echo $value;
            echo "<br/>";
        }
//        echo '<pre>';
//        print_r($data);
    }
}























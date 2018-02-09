<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/6/5
 * Time: 10:06
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\TyCourseArrange;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;
use AliyunSms\api_demo\SmsDemo;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    //<xml>
    //<appid><![CDATA[wx2421b1c4370ec43b]]></appid>
    //<attach><![CDATA[支付测试]]></attach>
    //<bank_type><![CDATA[CFT]]></bank_type>
    //<fee_type><![CDATA[CNY]]></fee_type>
    //<is_subscribe><![CDATA[Y]]></is_subscribe>
    //<mch_id><![CDATA[10000100]]></mch_id>
    //<nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
    //<openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
    //<out_trade_no><![CDATA[1409811653]]></out_trade_no>
    //<result_code><![CDATA[SUCCESS]]></result_code>
    //<return_code><![CDATA[SUCCESS]]></return_code>
    //<sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
    //<sub_mch_id><![CDATA[10000100]]></sub_mch_id>
    //<time_end><![CDATA[20140903131540]]></time_end>
    //<total_fee>1</total_fee>
    //<trade_type><![CDATA[JSAPI]]></trade_type>
    //<transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
    //</xml>

    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            try {
                $order = OrderModel::where('order_no', '=', $orderNo)
                    ->lock(true)
                    ->find();
                if ($order->status == 1) {
                    $service = new OrderService();
                    $stockStatus = $service->checkCourseOrderStock($order->id);
                    if ($stockStatus['pass']) {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($stockStatus);
//                        $this->addCodeImgById($order->id);
//                        $this->sendSMS($order->feature,$order->express,$order->order_no,$order->total_count);

                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
                return true;
            } catch (Exception $ex) {
                Db::rollback();
                Log::error($ex);
                return false;
            }
        } else {
            return true;
        }
    }

    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            //            $singlePStatus['count']
            TyCourseArrange::where('id', '=', $singlePStatus['id'])
                ->setDec('stock', $singlePStatus['counts']);
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ?
            OrderStatusEnum::PAID :
            OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)
            ->update(['status' => $status]);
    }

    /**
     * 增加二维码图片路径
     * @param $orderId
     * @return mixed
     */
    private function addCodeImgById($orderId)
    {
        $order = OrderModel::where('id', '=', $orderId)->find();
        $save_path = isset($_GET['save_path']) ? $_GET['save_path'] : BASE_PATH . 'qrcode/';  //图片存储的绝对路径
        //echo $save_path;die;
        $web_path = 'http://' . $_SERVER['HTTP_HOST'] . '/qrcode/';        //图片在网页上显示的路径

        $qr_data = isset($_GET['qr_data']) ? $_GET['qr_data'] : $order['order_no'];

        $qr_level = isset($_GET['qr_level']) ? $_GET['qr_level'] : 'H';

        $qr_size = isset($_GET['qr_size']) ? $_GET['qr_size'] : '10';

        $save_prefix = isset($_GET['save_prefix']) ? $_GET['save_prefix'] : 'ZETA';

        if ($filename = createQRcode($save_path, $qr_data, $qr_level, $qr_size, $save_prefix)) {

            $pic = $web_path . $filename;

        }
        $img_path = '/qrcode/' . $filename;
        OrderModel::where('order_no', '=', $order['order_no'])->update(['code_img' => $img_path]);
    }

    private function sendSMS($name,$phone,$code,$count)
    {
// 调用示例：
        set_time_limit(0);
        header('Content-Type: text/plain; charset=utf-8');
        SmsDemo::sendSms($name,$phone,$code,$count);
    }

}
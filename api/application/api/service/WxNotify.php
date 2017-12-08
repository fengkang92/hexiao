<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/6/5
 * Time: 10:06
 */

namespace app\api\service;

use app\api\model\BoxCourse;
use app\api\model\BoxCoursePlan;
use app\api\model\BoxCourseService;
use app\api\model\BoxMemberService;
use app\api\model\BoxServiceTime;
use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Cache;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

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
                    if ($order->time_id !== null) {
                        $stockStatus = $service->checkCourseOrderStock($order->id);
                    } else {
                        $stockStatus = $service->checkOrderStock($order->id);
                    }

                    if ($stockStatus['pass']) {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($order->time_id, $stockStatus, $order->id);
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

    private function reduceStock($time_id, $stockStatus, $order_id)
    {

        if (isset($time_id)) {
            foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
                //            $singlePStatus['count']
                BoxServiceTime::where('id', '=', $singlePStatus['id'])
                    ->setDec('stock', $singlePStatus['counts']);

            }
            $this->SmsSingleSenderCourse($order_id);
        } else {
            foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
                //            $singlePStatus['count']
                Product::where('id', '=', $singlePStatus['id'])
                    ->setDec('stock', $singlePStatus['counts']);

            }
            $this->SmsSingleSenderProduct($order_id);

        }

    }

    private function SmsSingleSenderProduct($id)
    {
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail) {
            throw new OrderException();
        }
        $phoneNumber = $orderDetail->snap_address->mobile;
        $params = array($orderDetail->snap_name, $orderDetail->total_count, $orderDetail->total_price, $orderDetail->express);
        $SmsSender = new SmsSender();
        $SmsSender->SmsSingleSender($phoneNumber, 51019, $params);
    }

    private function SmsSingleSenderCourse($id)
    {
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail) {
            throw new OrderException();
        }
        $memberService = BoxMemberService::where('id', '=', $orderDetail->time)->find();
        $boxCourseService = BoxCourseService::get($orderDetail->service_id);
        $memberService = BoxMemberService::get($orderDetail->time);
        $boxCoursePlan = BoxCoursePlan::get($boxCourseService->course_plan_id);
        $serviceTime = BoxServiceTime::get($orderDetail->time_id);
        $phoneNumber = $memberService->ytel;
        $code = $this->generate_code(6);
//        $url = config('doors.unlockUrl');
        $studentUrl = 'https://cs.api.joyfamliy.com/lock/student/Index/';
        $teacherUrl = 'https://cs.api.joyfamliy.com/lock/teacher/Index/';
        $params = array($orderDetail->snap_name, $orderDetail->total_count, $orderDetail->total_price,$studentUrl,$code);
        $paramsTeacher = array($boxCourseService->server_name,$memberService->yname,$boxCoursePlan->server_name,date('y-m-d H:i',$serviceTime->start_time),$teacherUrl);
        $SmsSender = new SmsSender();
        $SmsSender->SmsSingleSender($phoneNumber, 51756, $params);
        $SmsSender->SmsSingleSender($boxCourseService->tel, 51766, $paramsTeacher);
        $this->setCacheByOrderId($id,$code);
    }

    /**
     * 设置缓存，进行短信验证
     * @param $id
     * @param $code
     */
    private function setCacheByOrderId($id,$code)
    {
        $orderDetail = OrderModel::get($id);
        $boxCourse = BoxCourse::get($orderDetail->sid);
        $memberService = BoxMemberService::get($orderDetail->time);
        $serviceTime = BoxServiceTime::get($orderDetail->time_id);
        $device_name = $boxCourse->device_name;
        $member_service_id = $memberService->id;
        $start_time = $serviceTime->start_time;
        $end_time = $serviceTime->end_time;
        $data = json_encode(array('device_name'=>$device_name,'member_service_id'=>$member_service_id,'start_time'=>$start_time,'end_time'=>$end_time));
        $key = 'key'.date('md').$code;
        Cache::set($key,$data,$end_time);
    }

    private function generate_code($length = 6)
    {
        return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ?
            OrderStatusEnum::PAID :
            OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)
            ->update(['status' => $status]);
    }

}

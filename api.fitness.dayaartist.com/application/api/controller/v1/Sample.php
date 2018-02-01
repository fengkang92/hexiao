<?php

namespace app\api\controller\v1;

use app\api\model\Auth;
use app\api\model\BoxCourse;
use app\api\model\Order;
use app\api\model\BoxCoursePlan;
use app\api\model\BoxCourseService;
use app\api\model\BoxMemberService;
use app\api\model\BoxServiceTime;
use app\api\model\Order as OrderModel;
use app\api\service\Sample as SampleService;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\SampleGet;
use app\lib\exception\MissException;
use app\lib\exception\OrderException;
use Sms\SmsVoicePromtSender;
use Sms\SmsVoiceVeriryCodeSender;
use think\Controller;
use think\Loader;
use think\Request;
use app\api\service\SmsSender;

/*
 * Resource Sample
 */

Loader::import('SMS.SendTemplateSMS', EXTEND_PATH, '.php');

class Sample extends Controller
{

    /**
     * Sample 样例
     * @url     /sample/:key
     * @http    get
     * @param   int $key 键
     * @return  array of values , code 200
     * @throws  MissException
     */
    public function getSample($key)
    {
//        debug('begin');
        $validate = new SampleGet();
        $validate->goCheck();
        $key = (int)$key;
        $result = SampleService::getSampleByKey($key);
        if (empty($result)) {
            throw new MissException([
                'msg' => 'sample not found'
            ]);
        }
//        debug('end');
//        echo debug('begin','end').'s';
        return $result;
//        $data = [
//            'key' => $key,
//        ];
//        $result = $this->validate($data,'BannerGet');
//        if(true !== $result){
//            // 验证失败 输出错误信息
//            dump($result);
//        }
//        $key = (int)$key;
//        $result = BannerService::getBannerByLocation($key);
//        return $result;
    }

    public function test1()
    {
        $users = Auth::with(['hi' => function ($query) {
            $query->where('id', '>', 2);
        }])
            ->find(1);
        return $users;
    }

    public function test2($id = 1)
    {
        $n = input('param.');
        Request::instance()->get(['name' => 10]);
        echo input('get.name');

//        $t =session('count');
//        if(!$t)
//        {
//            session('count', 1);
//        }
//        else{
////            session()
//            session('count', $t +1);
//        }
//        echo (string)$t;
    }

    public function test3()
    {
        $n = input('param.');
        $m = input('post.');
    }

    public function test4($orderNo='AB29483050272132')
    {
        $save_path = isset($_GET['save_path']) ? $_GET['save_path'] : BASE_PATH . 'qrcode/';  //图片存储的绝对路径
        //echo $save_path;die;
        $web_path = 'http://' . $_SERVER['HTTP_HOST'] . '/qrcode/';        //图片在网页上显示的路径

        $qr_data = isset($_GET['qr_data']) ? $_GET['qr_data'] : 'http://apilab.dayaartist.com/index.php/api/v1/sample/sms?orderNo='.$orderNo;

        $qr_level = isset($_GET['qr_level']) ? $_GET['qr_level'] : 'H';

        $qr_size = isset($_GET['qr_size']) ? $_GET['qr_size'] : '10';

        $save_prefix = isset($_GET['save_prefix']) ? $_GET['save_prefix'] : 'ZETA';

        if ($filename = createQRcode($save_path, $qr_data, $qr_level, $qr_size, $save_prefix)) {

            $pic = $web_path . $filename;

        }
        $img_path = '/qrcode/' . $filename;
//        print_r($img_path);die();
//        echo "<img src='http://apilab.dayaartist.com/".$img_path."'>";die();
        return OrderModel::where('order_no', '=', $orderNo)->update(['code_img' => $img_path]);
    }

    public function generate_code($length = 6)
    {
        return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
    }

    public function sendSMS($id=1)
    {

        $orderDetail = OrderModel::get($id);
        var_dump($orderDetail);die();
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
        $url = 'https://cs.api.joyfamliy.com/lock/student/Index/';
        $params = array($orderDetail->snap_name, $orderDetail->total_count, $orderDetail->total_price,$url,$code);
        $paramsTeacher = array($boxCourseService->server_name,$memberService->yname,$boxCoursePlan->server_name,date('y-m-d H:i',$serviceTime->start_time),$url);
        $SmsSender = new SmsSender();
        $SmsSender->SmsSingleSender($phoneNumber, 51756, $params);
        $SmsSender->SmsSingleSender($boxCourseService->tel, 51766, $paramsTeacher);
        $this->setCacheByOrderId($id,$code);
    }
}

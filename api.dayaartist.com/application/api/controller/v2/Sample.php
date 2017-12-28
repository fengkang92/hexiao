<?php

namespace app\api\controller\v2;

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
use AliyunSms\api_demo\SmsDemo;

/*
 * Resource Sample
 */

//Loader::import('SMS.SendTemplateSMS', EXTEND_PATH, '.php');
//Loader::import('AliyunSms.SmsDemo', EXTEND_PATH, '.php');

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

    public function test4($orderNo = 'AB29483050272132')
    {
        $order = OrderModel::where('id', '=', 1)->find();
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
        print_r($img_path);
        die();
        echo "<img src='http://artists.com/" . $img_path . "'>";
        die();
        return OrderModel::where('order_no', '=', $orderNo)->update(['code_img' => $img_path]);
    }

    public function generate_code($length = 6)
    {
        return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
    }

    public function sendSMS($name="blacky",$phone=15510996092,$code=1314,$count=2)
    {
// 调用示例：
        set_time_limit(0);
        header('Content-Type: text/plain; charset=utf-8');

        $response = SmsDemo::sendSms($name,$phone,$code,$count);
        echo "发送短信(sendSms)接口返回的结果:\n";
        print_r($response);
    }
}

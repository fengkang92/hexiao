<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 24/10/2017
 * Time: 2:57 PM
 */

namespace app\api\service;

use Sms\SmsSingleSender;
use Sms\SmsMultiSender;
use Sms\SmsVoicePromtSender;
use Sms\SmsVoiceVeriryCodeSender;


class SmsSender
{
    private $appid = 1400046320;
    private $appkey = "dd06ebdd3a2af104d7c688a6f4ee6f4d";
    public function SmsSingleSender($phoneNumber,$templId,$params)
    {
        // 请根据实际 appid 和 appkey 进行开发，以下只作为演示 sdk 使用
        // appid,appkey,templId申请方式可参考接入指南 https://www.qcloud.com/document/product/382/3785#5-.E7.9F.AD.E4.BF.A1.E5.86.85.E5.AE.B9.E9.85.8D.E7.BD.AE
        $appid = $this->appid;
        $appkey = $this->appkey;
        $phoneNumber = $phoneNumber;
        $templId = $templId;


        $singleSender = new SmsSingleSender($appid, $appkey);

        // 普通单发
//        $result = $singleSender->send(0, "86", $phoneNumber, "测试短信，普通单发，深圳，小明，上学。", "", "");
//        $rsp = json_decode($result);
//        echo $result;
//        echo "<br>";


        // 指定模板单发
        // 假设模板内容为：测试短信，{1}，{2}，{3}，上学。
//        $params = array("1", "2","3","4");
        $params = $params;
        $result = $singleSender->sendWithParam("86", $phoneNumber, $templId, $params, "", "", "");
        $rsp = json_decode($result);
        echo $result;
        echo "<br>";
    }
    public function SmsMultiSender($phoneNumber,$templId){
        $appid = $this->appid;
        $appkey = $this->appkey;
        $templId = $templId;

        $multiSender = new SmsMultiSender($appid, $appkey);

        // 普通群发
        $phoneNumbers = array(15510996092,15510697937);
//        $result = $multiSender->send(0, "86", $phoneNumbers, "测试短信，普通群发，深圳，小明，上学。", "", "");
//        $rsp = json_decode($result);
//        echo $result;
//        echo "<br>";

        // 指定模板群发，模板参数沿用上文的模板 id 和 $params
        $params = array("指定模板群发", "深圳");
        $result = $multiSender->sendWithParam("86", $phoneNumbers, $templId, $params, "", "", "");
        $rsp = json_decode($result);
        echo $result;
        echo "<br>";
    }
}
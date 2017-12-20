<?php

namespace Admin\Controller;

use Think\Controller;

class ProcessController extends Controller
{
    /**
     * 
     */
    public function checkCourse()
    {
    	if (IS_POST) {
            $data = $_POST;
            
            foreach( $data as $k=>$v){  
                if( empty($v) ){
                    unset( $data[$k] );  
                }  
            }
            //print_r($data);die;
            $data = Array ('appid' =>'wyse0iljo4','course_id'=>0,'course_name'=>'30分钟学会弹钢琴','end_time' => 1514768400 ,'is_order' => 2,'is_private' =>2,'start_time'=>1514764800,'teacher_name'=>'孝文','teacher_tel'=>15936458953,'time'=>1512442368,'sign'=>'68c3d310a3443b506df2e758dab62b49464a6ab91b66d98092dfd5de224ce2de','token'=>'0iljo456lbn5bq9mshksijke55y79r0y');
	    	$url = 'http://118.89.243.186/phalapi/public/index.php?s=Order.checkTimeStock';
	    	//$url = '';
	    	//$data = curls($url,$data);
            //$info = sendRequest($url,false,'post',$data);
            $info['code'] = 200;
            if ($info['code'] == 200) {
                /*if (isset($info['data']['stock'])) {
                    echo "<script>alert('库存{$info['data']['stock']}')</script>";
                }else{*/
                    $this->success('成功', U('Admin/Process/payProess'));
                // }
            }else{
                echo $info['msg'];
            }
    	}else{
    		$this->display();
    	}
    }

    /**
     * 
     */
    public function payProess()
    {
    	if (IS_POST) {
            $data = $_POST;
            //$data = array('appid'=>'wyse0iljo4','time'=>1512442368,'trade_no'=>201712051636258079,'sign'=>'03620d88293c86f0f430ddf1e6a1ad3419ea1ce0b8487ffdebe5d3915f2e6ef4','token'=>'0iljo456lbn5bq9mshksijke55y79r0y');
            $url = "http://118.89.243.186/phalapi/public/index.php?s=Order.confirmOrder";
            //$info = sendRequest($url,false,'post',$data);
            $info['code'] = 200;
            if ($info['code'] == 200) {
                $this->success('可支付', U('Admin/Process/payOver'));
            }else{
                echo $info['msg'];
            }
        }else{
            $this->display();
        }
    }

    public function payOver()
    {
        if (IS_POST) {
            $data = array('appid'=>'wyse0iljo4','time'=>1512442368,'trade_no'=>201712051636258079,'status'=>1,'sign'=>'a8a7f80a4feaaecfdb4213a5743b70c007d4d55901a3991f24c33c014e5260a4','token'=>'0iljo456lbn5bq9mshksijke55y79r0y');
            $url = "http://118.89.243.186/phalapi/public/index.php?s=Order.PayOver";
            //$info = sendRequest($url,false,'post',$data);
            $info['code'] = 200;
            if ($info['code'] == 200) {
                $this->success('退款成功', U('Admin/Process/refundNotice'));
            }else{
                echo $info['msg'];
            }
        }else{
            $this->display();
        }
    }

    public function overs(){
        $this->display();
    }

    public function refundNotice()
    {
        if (IS_POST) {
            $data = $_POST;
            //$data = array('appid'=>'wyse0iljo4','time'=>1512442368,'trade_no'=>201712051636258079,'sign'=>'03620d88293c86f0f430ddf1e6a1ad3419ea1ce0b8487ffdebe5d3915f2e6ef4','token'=>'0iljo456lbn5bq9mshksijke55y79r0y');
            $url = "http://118.89.243.186/phalapi/public/index.php?s=Order.refundNotice";
            //$info = sendRequest($url,false,'post',$data);
            $info['code'] = 200;
            if ($info['code'] == 200) {
                $this->success('第三方退款成功', U('Admin/CourseTeacher/addCourseTeacher'));
            }else{
                echo $info['msg'];
            }
        }else{
            $this->display();
        }
    }

}
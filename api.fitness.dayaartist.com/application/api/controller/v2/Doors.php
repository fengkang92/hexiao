<?php 
namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\api\model\BoxMemberService;
use app\api\model\BoxServiceTime;
use app\api\model\BoxCourseService;
use app\api\model\BoxCourse;
use think\Controller;
use app\lib\exception\BaseException;
use think\Cache;

class Doors extends Controller
{
	/**
     * 检测微信用户
     * @param int $user_id 用户id号
     * @param int $time_id 时间id号
     * @param int $device_name 门锁名称
     * @return \think\Paginator
     * @throws ThemeException
     */
	public function checkWeChat($user_id,$time_id,$device_name)
	{
		$flag = true;
		if (is_numeric($user_id) && is_numeric($time_id)) {  //是否整数
			if ((($user_id + 0)< 0) && (($time_id + 0)< 0)) {  //是否正整数
				$flag = false;
			}
		}else{
			$flag = false;
		}

		if ($flag == false) {
			return [
	            'code' => -1,
	            'message' => '参数异常',
	            'value' => ''
	        ];
		}
		//用户是否预约
		$user_time = BoxMemberService::checkUserTime($user_id,$time_id);
		if (empty($user_time)) {
			return [
	            'code' => 0,
	            'message' => '数据不存在',
	            'value' => ''
	        ];
		}
		//是否在时间段内
		$time = BoxServiceTime::getBytimeSection($time_id);
		if (empty($time)) {
			return [
				'code' => 2,
            	'message' => '不在时间范围内',
            	'value' => ''
			];
		}

		$url = config('doors.VoiceUrl').'?AppKey='.config('doors.AppKey').'&DeviceName='.$device_name;

		return [
            'code' => 1,
            'message' => '成功',
            'value' => $url
        ];
	}

    /**
     * 检测第三方用户
     * @param int $check_num 验证码
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function otherUser($check_num)
    {
    	echo BASE_PATH;die;
    	echo $_SERVER['HTTP_HOST'].'/Public/qrcode/';die;
    	//Cache::clear();die;
    	//验证参数
    	//$flag = true;
    	if(empty($check_num)){
			return [
				'code' => 0,
            	'message' => '请输入验证码',
            	'value' => ''
			];
		}else{

			if (!is_numeric($check_num)) {
    		return [
	            'code' => -1,
	            'message' => '参数异常',
	            'value' => ''
	        ];
    	}	 
			
			if (strlen($check_num) != 6) {
				return [
		            'code' => -1,
		            'message' => '参数异常',
		            'value' => ''
		        ];
			}
		}

    	   				

		$brief_info = Cache::get('key'.date('md').$check_num);
		//echo $brief_info;die;
		if (empty($brief_info)) {
			return [
				'code' => 2,
            	'message' => '验证码有误',
            	'value' => ''
			];
		}

		$brief_info = json_decode($brief_info,true);

		if (($brief_info['start_time'] - 900) > time()) {
			
			return [
				'code' => 3,
				'message' => '上课前才可进入教室',
				'value' => ''
			];
			
		}
		if ($brief_info['end_time'] < time()) {
			return [
				'code' => 4,
				'message' => '课程已结束',
				'value' => ''
			];
		}
		
		$url = config('doors.VoiceUrl').'?AppKey='.config('doors.AppKey').'&DeviceName='.$brief_info['device_name'];
		return [
			'code' => 1,
			'message' => '成功',
			'value' => $url
		];
	}

    /**
     * 检测老师
     * @param int $name 姓名
     * @param int $tel 手机号
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function checkTeacher($name,$tel)
    {
    	
    	if (empty($name) || empty($tel)) {
    		return [
				'code' => 2,
				'message' => '请填写信息',
				'value' => ''
			];
    	}else{
    		$flag = true;
    		if (!is_numeric($tel)) {
	    		$flag = false;
	    	}else{
	    		if (strlen($tel) < 11 || strlen($tel) > 11) {
		    		$flag = false;
		    	}
	    	}
	    	if ($flag == false) {
				return [
		            'code' => -1,
		            'message' => '参数异常',
		            'value' => ''
		        ];
			}
    	}


    	$teacher_info = BoxCourseService::getOneTeacher($name,$tel);
    	if (empty($teacher_info)) {
    		return [
				'code' => -1,
				'message' => '老师不存在',
				'value' => ''
			];
    	}else{
    		$teacher_data = $teacher_info->toArray();
    		$course = BoxCourse::getOneCourse($teacher_data['sid']);
    		
			$url = config('doors.VoiceUrl').'?AppKey='.config('doors.AppKey').'&DeviceName='.$course['device_name'];

    		return [
				'code' => 1,
				'message' => '成功',
				'value' => $url
			];
    	}
    }
}
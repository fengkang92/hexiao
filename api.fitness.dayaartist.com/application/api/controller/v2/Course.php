<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/26
 * Time: 14:15
 */

namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;
use think\Controller;
use app\api\model\Ty_venue_branch as venueBranch;
use app\api\model\Ty_course_arrange as CourseArrange;
use app\api\model\Ty_img as ImgModel;

class Course extends Controller
{   
    /**
     * 课程安排
     * @param int $id 场馆分店ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function courseTimeList($id,$start_date='')
    {
        (new IDMustBePositiveInt())->goCheck();
        
        if (empty($start_date)) {
            $start_date = date('Y-m-d', strtotime('-1 days'));
        }
        $end_date = date('Y-m-d', strtotime('+7 days'));

        $TimeInfo = array();

        $CourseTime = CourseArrange::CourseTimeList($id,$start_date,$end_date); //课程时间列表
        $Venue = Ty_venue_branch::VenueDetails($id);   //场馆信息
        $venueImg = ImgModel::getManyImg($Venue['img_id']);


        if (empty($data)) {
            return [
                'code' => 404,
                'msg' => '暂无课程'
            ];
        }

        
        foreach ($CourseTime as $key => $v) {
            
        }

        return $data->toArray();
    }

}
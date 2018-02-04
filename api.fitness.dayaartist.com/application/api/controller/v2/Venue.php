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

class Venue extends Controller
{   
    /**
     * 场馆列表
     * @param int $longitude 经度
     * @param int $latitude 纬度
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getVenueList()
    {
        $data = venueBranch::VenueList();
        
        if (empty($data)) {
            return [
                'code' => 404,
                'msg' => '暂无数据'
            ];
        }
        
        foreach ($data as $key => $v) {
            $distance = getDistance($longitude,$latitude,$v['longitude'],$v['latitude']);
            $data[$key]['distance'] = $distance;
        }

        sortArrByOneField($data,'distance',false);
        return $data;
    }

    /**
     * 场馆详情
     * @param int $id 预约时间ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getVenueDetails($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $data = venueBranch::VenueDetails($id);
        if (empty($data)) {
            return [
                'code' => 404,
                'msg' => '暂无数据'
            ];
        }

        return $data->toArray();
    }

    /**
     * 课程安排
     * @param int $id 场馆分店ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function courseTimeList($id,$dates=date('Y-m-d'))
    {
        echo date('Y-m-d', strtotime('+7 days'));die;
        (new IDMustBePositiveInt())->goCheck();
        
        $data = CourseArrange::CourseTimeList($id,$dates);
        if (empty($data)) {
            return [
                'code' => 404,
                'msg' => '暂无数据'
            ];
        }

        return $data->toArray();
    }

}
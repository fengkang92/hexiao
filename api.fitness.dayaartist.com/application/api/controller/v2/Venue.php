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
use app\api\model\Ty_venue as VenueModel;
use app\api\model\Ty_venue as VenueModel;

class Venue extends Controller
{   
    /**
     * 场馆列表
     * @param int $user_id 用户id号
     * @param int $time_id 时间id号
     * @param int $device_name 门锁名称
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getVenueList($longitude,$latitude)
    {

        $data = VenueModel::VenueList();
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
        $data = VenueModel::VenueDetails($id);
        if (empty($data)) {
            return [
                'code' => 404,
                'msg' => '暂无数据'
            ];
        }

        return $data->toArray();
    }

}
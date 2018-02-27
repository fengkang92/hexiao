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
use app\api\model\TyVenueBranch as VenueBranch;
use app\api\model\TyImg as ImgModel;

class Venue extends Controller
{   
    /**
     * 场馆列表
     * @param int $longitude 经度
     * @param int $latitude  纬度
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getVenueList($longitude,$latitude)
    {
        $data = VenueBranch::VenueList();
        if (empty($data)) {
            return [
                'code' => 404,
                'msg' => '暂无数据'
            ];
        }
        
        foreach ($data as $key => $v) {
            if (empty($v['collection'])) {
                $data[$key]['collection'] = array('status'=>2);
            }
            $distance = getdistances($longitude,$latitude,$v['longitude'],$v['latitude']);
            $data[$key]['distance'] = round($distance/1000,2).'km';
            $main_img = ImgModel::getOneImg($v['main_img_id']);
            $logo_img = ImgModel::getOneImg($v['logo_id']);
            $data[$key]['main_img'] = $main_img['img_url'];
            $data[$key]['log_img'] = $logo_img['img_url'];
        }

        sortArrByOneField($data,'distance',false);
        return $data;
    }

    /**
     * 场馆详情
     * @param int $id 场馆ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getVenueDetails($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $venue = VenueBranch::VenueDetails($id);

        if (empty($venue)) {
            return [
                'code' => 404,
                'msg' => '参数异常'
            ];
        }

        $img = ImgModel::getManyImg($venue['img_id']);

        foreach ($img as $key => $v) {
            $venue['img'][] = $v['img_url'];
        }

        return $venue;
    }

}
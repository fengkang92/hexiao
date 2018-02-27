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
use app\api\service\Token;
use app\api\model\TyCollection as CollectionModel;
use app\api\model\TyImg as ImgModel;

class Collection extends Controller
{   
    /**
     * 收藏
     * @param int $id 场馆ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function collectByUser($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $uid = Token::getCurrentUid();
        $data = CollectionModel::getUserCollect($uid,$id);
        if (!empty($data)) {
            if ($data['status'] == 1) {
                return [
                    'code'=> 20001,
                    'msg' => '您已收藏该场馆'
                ];
            }else{
                $collection = new CollectionModel;
                $where = array('user_id'=>$uid,'venue_branch_id'=>$id);
                $res = $collection->where($where)
                    ->update(['status' => 1,'update_time'=>time()]);
            }
        }else{
            $collection = new CollectionModel;
            $collection->user_id = $uid;
            $collection->venue_branch_id = $id;
            $collection->status = 1;
            $collection->create_time = time();
            $collection->save();
            $res = $collection->id;
        }
        
        if ($res > 0) {
            return  [
                'code' => 200,
                'msg' => '成功'
            ];
        }
        
    }

    /**
     * 取消收藏
     * @param int $id 场馆ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function cancelCollect($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $uid = Token::getCurrentUid();
        $collection = new CollectionModel;
        $where = array('user_id'=>$uid,'venue_branch_id'=>$id);
        $res = $collection->where($where)
            ->update(['status' => 2,'update_time'=>time()]);
        if ($res != 1) {
            return [
                'code' => 500,
                'msg' => '服务器走神了'
            ];
        }else{
            return  [
                'code' => 200,
                'msg' => '成功'
            ];
        }
    }

    /**
     * 收藏列表
     * @param int $id 用户ID
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function collectionList($longitude,$latitude)
    {
        $uid = Token::getCurrentUid();
        $collection = CollectionModel::getUserCollection($uid);
        if (empty($collection)) {
            return [
                'code' => 404,
                'msg' => '您暂时还没有收藏场馆哦'
            ];
        }
        $collectionData = array();
        foreach ($collection as $key => $v) {
            $distance = getdistances($longitude,$latitude,$v['venue']['longitude'],$v['venue']['latitude']);
            $distance = round($distance/1000,2).'km';
            $venue_img = ImgModel::getOneImg($v['venue']['main_img_id']);
            $collectionData[] = array('venue_id'=>$v['venue']['id'],'name'=>$v['venue']['name'],'address'=>$v['venue']['address'],'img'=>$venue_img['img_url'],'status'=>$v['status'],'distance'=>$distance);
        }

        sortArrByOneField($collectionData,'distance',false);
        /*echo '<pre>';
        print_r($collectionData);die;*/
        return $collectionData;
    }
}
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
use app\api\model\Ty_collection as CollectionModel;

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
        //$uid = Token::getCurrentUid();
        $uid = 1;
        $collection = new CollectionModel;
        $collection->user_id = $uid;
        $collection->venue_branch_id = $id;
        $collection->status = 1;
        $collection->create_time = time();
        $collection->save();
        $res = $collection->id;
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
        //$uid = Token::getCurrentUid();
        $uid = 1;
        $collection = new CollectionModel;
        $where = array('user_id'=>1,'venue_branch_id'=>$id);
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
}
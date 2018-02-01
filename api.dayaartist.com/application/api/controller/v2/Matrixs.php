<?php

namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;
use think\Controller;
use app\lib\exception\BaseException;
use App\Domain\Common as CommonDomain;
use think\cache\driver\Redis;

class Matrixs extends Controller
{
    /**
     * 矩阵入队
     * @param int $id 矩阵ID
     * @return \think\Paginator 
     * @throws ThemeException
     */
    public function newsPush($callback,$id)
    {
        if (!is_numeric($id)) {
            return [
                'code' => 400,
                'msg' => '参数异常'
            ];
        }   
        $redis = new Redis();
        
        $res = $redis->lpush('matrix',$id);
        /*$num = $redis->lrange('matrix',0,-1);
        echo $res.'<br>';
        print_r($num);die;*/
        $data = array('code'=>200,'msg'=>'成功','data'=>$res);
        echo $callback.'('.json_encode($data).')';
    }

    public function testNewsPush($id)
    {
        if (!is_numeric($id)) {
            return [
                'code' => 400,
                'msg' => '参数异常'
            ];
        }   
        $redis = new Redis();
        
        $res = $redis->lpush('matrix',$id);
        /*$num = $redis->lrange('matrix',0,-1);
        echo $res.'<br>';
        print_r($num);die;*/
        return $res;
    }

    /**
     * 矩阵出队
     * @param int $id 矩阵ID
     * @return \think\Paginator 
     * @throws ThemeException
     */
    public function newsPop()
    {  
        $redis = new Redis();
        $res = $redis->rpop('matrix');

        /*$num = $redis->lrange('matrix',0,-1);
        echo $res.'<br>';
        print_r($num);die;*/

        if (empty($res)) {
            $data['data'] = 0; 
        }else{
           $data['data'] = $res; 
        }

        return $data;
    }

    /**
     * 矩阵清除
     * @return \think\Paginator 
     * @throws ThemeException
     */
    public function newsClear()
    {  
        $redis = new Redis();
        $redis->clear();die;
        return [
            'code'=>200
        ];
    }
}
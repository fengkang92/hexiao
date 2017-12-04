<?php

namespace app\api\model;

use think\Model;

class Product extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from',
        'create_time', 'update_time'];

    /**
     * 图片属性
     */
    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function getHomeImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }


    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany('ProductTag', 'product_id', 'id');
    }

    public function size()
    {
        return $this->hasMany('ProductSize', 'product_id', 'id');
    }

    public function feature()
    {
        return $this->hasMany('ProductFeature', 'product_id', 'id');
    }

    public function time()
    {
        return $this->hasMany('ProductTime', 'product_id', 'id')->order('delete_time', 'desc');
    }

    /**
     * 获取某分类下商品
     * @param $categoryID
     * @param int $page
     * @param int $size
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getProductsByCategoryID(
        $categoryID, $summary, $paginate = true, $page = 1, $size = 30)
    {
        $query = self::with('tags')
            ->where('category_id', '=', $categoryID)
            ->where('summary', '=', $summary)
            ->where('del',1);
        
        if (!$paginate) {
            return $query->select();
        } else {
            // paginate 第二参数true表示采用简洁模式，简洁模式不需要查询记录总数
            return $query->paginate(
                $size, true, [
                'page' => $page
            ]);
        }
    }

    /**
     * 获取商品详情
     * @param $id
     * @return null | Product
     */
    public static function getProductDetail($id)
    {
        //千万不能在with中加空格,否则你会崩溃的
        //        $product = self::with(['imgs' => function($query){
        //               $query->order('index','asc');
        //            }])
        //            ->with('properties,imgs.imgUrl')
        //            ->find($id);
        //        return $product;

        $product = self::with(
            [
                'imgs' => function ($query) {
                    $query->with(['imgUrl'])
                        ->order('order', 'asc');
                }, 'properties'])
//            ->with('properties')
            ->find($id);
        return $product;
    }

    public function getProductOrder($id)
    {
        $product = self::with(['size', 'feature', 'time'])
//            ->with('feature')
//            ->with('time')
            ->find($id);
//        $product = json_decode($product);
//        $product = json_encode($product);
//        dump($product['time']);die;
        if ($product['summary'] == 1) {
            $product = $this->checkProductTime($product);
        }
//        $product = json_encode($product['time'],true);
        return $product;
    }

    /**    循坏检测预约时间,
     * 清理失效时间段*/
    public function checkProductTime($product)
    {
        date_default_timezone_set('Asia/Shanghai');
        $now = strtotime("now");
//        $product = json_decode($product, true);
        $j = 0;
        $cproduct = [];
        for ($i = 0; $i < count($product['time']); $i++) {
            $time = strtotime($product['time'][$i]['start_time']);
            if ($time - $now > config('setting.product_time')) {
                $cproduct['time'][$j]['start_time'] =
                    $product['time'][$i]['start_time'] . '--' . substr($product['time'][$i]['end_time'], -5);
                $j++;
            }
        }
        $product['time'] = $cproduct['time'];
//        $product = json_encode($product);
        return $product;
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->where('hot&del',1)
//            ->where('del',1)
            ->select();
        return $products;
    }

}

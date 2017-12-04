<?php
/**
 * Created by 七月.
 * User: 七月
 * Date: 2017/2/15
 * Time: 1:00
 */

namespace app\api\controller\v1;

use app\api\model\Product as ProductModel;
use app\api\model\BoxCoursePlan;
use app\api\model\BoxCourseService;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\lib\exception\ParameterException;
use app\lib\exception\ProductException;
use app\lib\exception\ThemeException;
use think\Controller;
use think\Exception;

class Product extends Controller
{
    protected $beforeActionList = [
        'checkSuperScope' => ['only' => 'createOne,deleteOne']
    ];

    /**
     * 根据类目ID获取该类目下所有商品(分页）
     * @url /product?id=:category_id&page=:page&size=:page_size
     * @param int $id 商品id
     * @param int $page 分页页数（可选)
     * @param int $size 每页数目(可选)
     * @return array of Product
     * @throws ParameterException
     */
    public function getByCategory($id = -1, $page = 1, $size = 30)
    {
        (new IDMustBePositiveInt())->goCheck();
        (new PagingParameter())->goCheck();
        $pagingProducts = ProductModel::getProductsByCategoryID(
            $id, true, $page, $size);
        if ($pagingProducts->isEmpty()) {
            // 对于分页最好不要抛出MissException，客户端并不好处理
            return [
                'current_page' => $pagingProducts->currentPage(),
                'data' => []
            ];
        }
        //数据集对象和普通的二维数组在使用上的一个最大的区别就是数据是否为空的判断，
        //二维数组的数据集判断数据为空直接使用empty
        //collection的判空使用 $collection->isEmpty()

        // 控制器很重的一个作用是修剪返回到客户端的结果

        //        $t = collection($products);
        //        $cutProducts = collection($products)
        //            ->visible(['id', 'name', 'img'])
        //            ->toArray();

        //$collection = collection($pagingProducts->items());
        $data = $pagingProducts
        //->hidden(['summary'])
            ->toArray();
        // 如果是简洁分页模式，直接序列化$pagingProducts这个Paginator对象会报错
        //        $pagingProducts->data = $data;
        return [
            'current_page' => $pagingProducts->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 获取某分类下全部商品(不分页）
     * @url /product/all?id=:category_id
     * @param int $id 分类id号
     * @return \think\Paginator
     * @throws ThemeException
     */
    //summary为1表示预约商品，为0表示传统商品
    public function getAllInCategory($id = -1, $summary = 0)
    {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID(
            $id, $summary, false);
        //echo ProductModel::getLastSql();die;
        if ($products->isEmpty()) {
            throw new ThemeException();
        }
        $data = $products
            ->toArray();
        return $data;
    }

    /**
     * 获取指定数量的最近热销商品
     * @url /product/recent?count=:count
     * @param int $count
     * @return mixed
     * @throws ParameterException
     */
    public function getRecent($count = 9)
    {
        
        (new Count())->goCheck();

        $hot_data = array();
        //热销商品
        $products = ProductModel::getMostRecent($count);

        if ($products->isEmpty()) {
            $products = '';
            // $hot_data['product'] = '';

        }else{
            $hot_data['product'] = $products->toArray();
        }

        //热销课程
        $hot_curr = BoxCoursePlan::getHotCoursePlan($count);
        if (empty($hot_curr)) {
            $hot_data['time'] = '';
        }else{
            $data['data'] = $hot_curr;
            $hot_curr = BoxCourseService::getByCourseMinPrice($data);
            $hot_data['time'] = $hot_curr['data'];
        }
        //return $products;
        return $hot_data;
    }

    /**
     * 获取商品详情
     * 如果商品详情信息很多，需要考虑分多个接口分布加载
     * @url /product/:id
     * @param int $id 商品id号
     * @return Product
     * @throws ProductException
     */
    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;
    }

    public function getOneOrder($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $ProductModel = new ProductModel;
        $product = $ProductModel->getProductOrder($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;
    }

    public function createOne()
    {
        $product = new ProductModel();
        $product->save(
            [
                'id' => 1
            ]);
    }

    public function deleteOne($id)
    {
        ProductModel::destroy($id);
        //ProductModel::destroy(1,true);
    }

}

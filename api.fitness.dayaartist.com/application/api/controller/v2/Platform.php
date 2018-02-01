<?php

namespace app\api\controller\v2;

use think\Controller;
use app\api\validate\IDMustBePositiveInt;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;
use think\Loader;
Loader::import('Share.jssdk', EXTEND_PATH, '.php'); 
class Platform extends Controller
{
	/**
     * 获取商品列表
     */
	public function shoplist()
	{
		$shoplist = ProductModel::getProductlist();
		if (empty($shoplist)) {
			return [
				'code' => 0,
				'msg' => '服务器异常',
				'data' => ''
			];
		}

        $shoplist = $shoplist->toarray();

        //print_r($shoplist);die;

        foreach ($shoplist as $key => $value) {
            $img[] = $value['imgs'];
            unset($shoplist[$key]['imgs']);
        }
        //print_r($img);die;
		foreach ($img as $key => $value) {
            foreach ($value as $k => $v) {
                $shoplist[$key]['img'][] = $v['url'];
            }
        }
		return $shoplist;
	}

    /**
     * 获取商品详情id
     * @url /product/:
     * @param int $id 商品id号
     * @return Product
     */
    public function shopDetails($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }

        $product = $product->toarray();
        $imgs = $product['imgs'];

        unset($product['imgs']);
        foreach ($imgs as $key => $v) {
        	$product['img'][] = $v['url'];
        }
        return $product;
    }

    /**
     * 微信分享
     */
    public function share($url)
    {
        $data = \jssdk::GetSignPackage($url);
        return $data;
    }
}
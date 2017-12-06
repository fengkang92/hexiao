<?php

namespace app\api\controller\v2;

use think\Controller;
use app\api\validate\IDMustBePositiveInt;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;
class Platform extends Controller
{
	/**
     * 获取商品列表
     */
	public function shoplist()
	{
		$product = ProductModel::getProductDetail($id);
	}

    /**
     * 获取商品详情id
     * @url /product/:
     * @param int $id 商品id号
     * @return Product
     * @throws ProductException
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
}
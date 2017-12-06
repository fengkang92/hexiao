// var productObj = require('product-model.js');

import { Product } from 'product-model.js';
import { Cart } from '../cart/cart-model.js';
import { Category } from '../category/category-model.js';

var product = new Product();  //实例化 商品详情 对象
var cart = new Cart();
var category = new Category;

var WxParse = require('../../wxParse/wxParse.js');

Page({
	data: {
		isFly: true,
		currentTabsIndex: 0,
		content: null
	},
	onLoad: function (options) {
		this.setData({
			id: options.id,
			type: options.type,
		})
		this._loadData();
	},

	/*加载所有数据*/
	_loadData: function (callback) {
		var that = this;
		product.getProductInfo(this.data.id, (data) => {
			console.log(data)
			that.setData({
				product: data,
				type: data.category_id,
				summary: data.summary,
				content: WxParse.wxParse('content', 'html', data.content, that, 5)
			});
			callback && callback();
			//获取当前商品分类下所有商品作为推荐商品
			//注意异步问题
			product.getMoreByCategory(this.data.type, 0, (res) => {
				that.setData({
					moreProductsArr: res
				})
			})
		});

	},

	//商品详情点击更多商品
	onProductsItemTap: function (event) {
		var id = product.getDataSet(event, 'id');
		var type = product.getDataSet(event, 'type');
		var summary = product.getDataSet(event, 'summary');
		wx.redirectTo({
			url: '../product/product?id=' + id + '&type=' + type + '&summary=' + summary
		})
	},

	//切换详情面板
	onTabsItemTap: function (event) {
		var index = product.getDataSet(event, 'index');
		this.setData({
			currentTabsIndex: index
		});
	},
	//点击查看地图
	onAddressTap: function (event) {
		wx.openLocation({
			latitude: 39.899117,
			longitude: 116.47062,
			scale: 28,
			name: '黑弧数码文化传媒股份有限公司',
			address: '北京市朝阳区百子湾路32号二十二院街艺术区6号楼20号'
		})
	},

	/*提交订单*/
	submitOrder: function (events) {
		if (this.data.product.stock != 0) {
			//可以购买
			console.log(1);
			wx.navigateTo({
				url: '../order/order?productId=' + this.data.id + '&from=product'
			});
		} else {
			wx.showModal({
				title: '购买失败',
				content: '该商品已下架！',
				showCancel: false,
				success: function (res) { 
					return;
				}
			});
		
		}
	},

	//分享效果
	onShareAppMessage: function () {
		return {
			title: this.data.product.name
		}
	}

})



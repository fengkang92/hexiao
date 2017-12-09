import { Product } from 'product-model.js';

var product = new Product();  //实例化 商品详情 对象

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
		})
		this._loadData();
	},

	/*加载所有数据*/
	_loadData: function (callback) {
		var that = this;
		product.getProductInfo(this.data.id, (data) => {
			console.log(data)
			that.setData({
				id:data.id,
				product: data,
				content: WxParse.wxParse('content', 'html', data.content, that, 5)
			});
			callback && callback();
		});

	},
	//点击查看地图
	onAddressTap: function (event) {
		// wx.openLocation({
		// 	latitude: 39.899117,
		// 	longitude: 116.47062,
		// 	scale: 28,
		// 	name: '黑弧数码文化传媒股份有限公司',
		// 	address: '北京市朝阳区百子湾路32号二十二院街艺术区6号楼20号'
		// })
	},

	/*提交订单*/
	submitOrder: function (events) {
		if (this.data.product.stock != 0) {
			//可以购买
			wx.navigateTo({
				url: '../order/order?productId=' + this.data.id,
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
	}

})



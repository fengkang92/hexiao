// home.js

import { Home } from 'home-model.js';
var home = new Home();
//引入全局变量
import { Config } from "../../utils/config.js";

Page({

    /**
     * 页面的初始数据
     */
    data: {

    },

    onShow: function () { 
        //获取数据
        this._loadData();
    },

    _loadData: function () {
        home.getProductsData((res) => {
			console.log(res);
            this.setData({
				productsArr: res,
            });
        });
    },

    //推荐商品进入商品详情
	onproductTap: function (event) {
		//判断是传统商品还是预约商品
        var id = home.getDataSet(event, 'id');
		console.log(id);
        wx.navigateTo({
            url: '../product/product?id=' + id,
        })
    },

    //商品分类进入商品列表
    onCategoryItemTap: function (event) {
        var id = home.getDataSet(event, 'id');
        var name = home.getDataSet(event, 'name');
        wx.navigateTo({
            url: '../category/category?id=' + id + '&name=' + name,
        })
    },

    //bannner点击跳转
    onBannerTap: function (event) {
        var name = home.getDataSet(event, 'key');
        var id = home.getDataSet(event, 'type');
        if (id != 0) {
            wx.navigateTo({
                url: '../category/category?id=' + id + '&name=' + name,
            })
        }
    },

	//跳转到卓儿小程序
	jumpToJoy:function(){
		wx.navigateToMiniProgram({
			appId: 'wxb489506e9a167248',
			path: 'pages/item/home',
			envVersion: 'release',
			success(res) {
				// 打开成功
			},
			fail:function(){
				wx.showModal({
					title: '黑弧文艺社',
					content: '系统错误，请稍后重试！',
					showCancel: false,
					success: function (res) {

					}
				});
			}
		})
	},

    //分享效果
    onShareAppMessage: function () {

    }
})
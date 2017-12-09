// about.js

import { Address } from '../../utils/address.js';
import { Order } from '../order/order-model.js';
import { About } from 'about-model.js';

var address = new Address();
var order = new Order();
var about = new About();

Page({

    /**
     * 页面的初始数据
     */
	data: {
		loadingHidden: true,
		again: true
	},

    /**
     * 生命周期函数--监听页面加载
     */
	onLoad: function (options) {
	},
	//切换
	change:function(){
		wx.navigateToMiniProgram({
			appId: 'wx3c2fb6d6439c904a',
			path: 'pages/home/home',
			envVersion: 'release',
			success(res) {
				// 打开成功
			},
			fail: function () {
				wx.showModal({
					title: '达雅文化',
					content: '系统错误，请稍后重试！',
					showCancel: false,
					success: function (res) {

					}
				});
			}
		})
	},

    /**
     * 用户点击右上角分享
     */
	onShareAppMessage: function () {

	}
})
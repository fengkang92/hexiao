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
		wx.redirectTo({
			url: '../check/c-home/c-home',
		})
	}
})
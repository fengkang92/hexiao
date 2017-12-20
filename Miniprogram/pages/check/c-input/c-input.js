// pages/input/input.js
import { Menu } from '../c-menu/menu-model.js';
var menu = new Menu();
//引入全局变量
import { Config } from "../../../utils/config.js";

Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		code:null
	},

	/**
	 * 生命周期函数--监听页面加载
	 */
	onLoad: function (options) {

	},

	codeInput: function (e) {
		this.setData({
			code: e.detail.value
		})
	},

	onSureTap:function(){
		if (this.data.code.length==12){
			//后台
			wx.redirectTo({
				url: '../c-detail/c-detail?code='+this.data.code,
			})
		}else{
			wx.showModal({
				title: '提示',
				showCancel: false,
				content: '请输入正确核销码',
				success: function () { },
			})
		}
	},

	/**
	 * 用户点击右上角分享
	 */
	onShareAppMessage: function () {

	}
})
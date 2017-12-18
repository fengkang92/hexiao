// pages/menu/menu.js
import { Menu } from 'menu-model.js';
var menu = new Menu();

Page({

	/**
	 * 页面的初始数据
	 */
	data: {

	},

	/**
	 * 生命周期函数--监听页面加载
	 */
	onLoad: function (options) {

	},

	//扫码
	onQrTap: function () {
		// 只允许从相机扫码
		wx.scanCode({
			onlyFromCamera: true,
			success: (res) => {
				console.log(res);
				var code = res.result;
				wx.navigateTo({
					url: '../c-detail/c-detail?code=' + code,
				})
			}
		})
	},
	//输入票号
	onNumTap: function () {
		wx.navigateTo({
			url: '../c-input/c-input',
		})
	},
	//验票记录
	onListTap: function () {
		wx.navigateTo({
			url: '../c-list/c-list',
		})
	},
	// //跳转到用户小程序
	change: function () {
		wx.switchTab({
			url: '../../home/home',
		})
	}
})
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
		this._loadData();
	},
	_loadData: function () {
		var that = this;
		wx.login({
			success: function () {
				wx.getUserInfo({
					success: function (res) {
						console.log(res);
						that.setData({
							nickName: res.userInfo.nickName,
							avatarUrl: res.userInfo.avatarUrl,
						})
					},
					fail: function (res, callBack) {
						wx.showModal({
							title: '警告',
							content: '您点击了拒绝授权,将无法正常显示个人信息,点击确定重新获取授权。',
							success: function (res) {
								if (res.confirm) {
									wx.openSetting({
										success: (res) => {
											if (res.authSetting["scope.userInfo"]) {////如果用户重新同意了授权登录
												wx.getUserInfo({
													success: function (res) {
														that.setData({
															nickName: res.userInfo.nickName,
															avatarUrl: res.userInfo.avatarUrl,
														})
													},
												})
											}
										},
										fail: function (res) {
											that.setData({
												nickName: 'Literature',
												avatarUrl: '../../images/icon/user@default.png',
											})
										}
									})
								}
							}
						})
					}
				})
			},
			fail: function () {
				that.setData({
					nickName: 'Literature',
					avatarUrl: '../../images/icon/user@default.png',
				})
			}
		})
	},

	//向后台发送用户数据
	_postData: function (data) {
		var info = data;
		var that = this;
		about.postData(info, (res) => {
			if (res.code == 2 && that.data.again) {
				that.setData({
					again: false
				})
				about.postData(info, (res) => {
					console.log(res);
				})
			}
		})
	},
	//进入我的订单
	onMyOrderTap: function () {
		wx.navigateTo({
			url: '../my-order/my-order',
		})
	},
	//客服电话
	onMakePhoneCall: function () {
		wx.makePhoneCall({
			phoneNumber: '010-53511056',
		})
	},
	//关于我们
	onShowModal: function () {
		wx.showModal({
			title: '盒子文艺社',
			content: '一个线上线下以“艺术生活化”极致感受体验的空间，同时也是一个集中艺术、音乐、戏剧、阅读、美食、生活艺术、艺术生活为内容的体验集合地，愿您与伴侣和孩子共享文化艺术融入生活，坚信人文关怀，将文化艺术的种子植入自身。',
			showCancel: false
		})
	},
    /**
     * 用户点击右上角分享
     */
	onShareAppMessage: function () {

	}
})
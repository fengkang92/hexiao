// my.js

import { Address } from '../../utils/address.js';
import { Order } from '../order/order-model.js';
import { My } from 'my-model.js';

var address = new Address();
var order = new Order();
var my = new My();

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
		this._getUserInfo();
		this._loadData();
	},
	_getUserInfo: function () {
		var that = this;
		wx.login({
			success: function () {
				wx.getUserInfo({
					success: function (res) {
						console.log(res);
						that._postData(res.userInfo);
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
														that._postData(res.userInfo);
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
		my.postData(info, (res) => {
			if (res.code == 2 && that.data.again) {
				that.setData({
					again: false
				})
				my.postData(info, (res) => {
					console.log(res);
				})
			}
		})
	},
	//获取订单
	_loadData:function(){
		my.getOrders(1,(res)=>{
			this.setData({
				orderList: res.data,
				index: res.current_page
			})
		})
	},


    /**
     * 用户点击右上角分享
     */
	onShareAppMessage: function () {

	}
})
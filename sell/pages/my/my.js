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
		this._loadData();
		this._getUserAddressInfo();
	},
	_loadData: function () {
		var that = this;
		wx.getUserInfo({
			success: function (res) {
				console.log(res)
				that.setData({
					userInfo: res.userInfo,
					loadingHidden: true
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
									console.log(res);
									if (res.authSetting["scope.userInfo"]) {////如果用户重新同意了授权登录
										wx.getUserInfo({
											success: function (res) {
												that.setData({
													userInfo: res.userInfo,
													loadingHidden: true
												});
												that._postData(res.userInfo)
											}
										})
									}
								},
								fail: function (res) {
									typeof callBack == "function" && callBack({
										avatarUrl: '../../images/icon/user@default.png',
										nickName: 'Literature'
									})
								}
							})
						}
					}

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

	//获取用户地址信息
	_getUserAddressInfo: function () {
		address.getAddress((res) => {
			this._bindAddressInfo(res);
		})
	},
	//绑定用户地址信息
	_bindAddressInfo: function (res) {
		this.setData({
			addressInfo: res
		})
	},
	/*修改或者添加地址信息*/
	editAddress: function (event) {
		var that = this;
		wx.chooseAddress({
			success: function (res) {
				var addressInfo = {
					name: res.userName,
					mobile: res.telNumber,
					totalDetail: address.setAddressInfo(res)
				};
				if (res.telNumber) {
					that._bindAddressInfo(addressInfo);
					//保存地址
					address.submitAddress(res, (flag) => {
						if (!flag) {
							that.showTips('操作提示', '地址信息更新失败！');
						}
					});
				}
				//模拟器上使用
				else {
					that.showTips('操作提示', '地址信息更新失败,手机号码信息为空！');
				}
			},
			fail: function(res){
				wx.showModal({
					title: '警告',
					content: '您点击了拒绝授权,将无法查看并管理地址信息，点击确定重新获取授权。',
					success: function (res) {
						if (res.confirm) {
							wx.openSetting({
								success: (res) => {
									console.log(res);
								},
								fail: function (res) {
	
								}
							})
						}
					}

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
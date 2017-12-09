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
		again: true,
		pageIndex:1,
		orderList:[],
		isLoadedAll:false,
	},

    /**
     * 生命周期函数--监听页面加载
     */
	onShow: function (options) {
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
				pageIndex: res.current_page
			})
		})
	},

	/*下拉刷新页面*/
	onPullDownRefresh: function () {
		this._refresh();
	},

	// _refresh: function () {
	// 	var that = this;
	// 	that.data.orderList = [];  //订单初始化
	// 	that._getAllOrders(() => {
	// 		that.data.isLoadedAll = false;  //是否加载完全
	// 		that.data.pageIndex = 1;
	// 		wx.stopPullDownRefresh();
	// 		order.execSetStorageSync(false);  //更新标志位
	// 	});
	// },

	//获取所有订单
	// _getAllOrders: function (callback) {
	// 	my.getOrders(this.data.pageIndex, (res) => {
	// 		var data = res.data;
	// 		if (data.length > 0) {
	// 			this.data.orderList.push.apply(this.data.orderList, data);
	// 			this.setData({
	// 				orderList: this.data.orderList,
	// 				loadingHidden: true
	// 			})
	// 		} else {
	// 			//已经全部加载完
	// 			this.data.isLoadedAll = true;
	// 		}
	// 		callback && callback();
	// 	})
	// },

	//详情
	onOrderTap:function(event){
		var type = my.getDataSet(event, 'type');
		wx.navigateTo({
			url: '../order-detail/order-detail?id='+type,
		})
	},

	//关于我们
	about:function(){
		wx.navigateTo({
			url: '../about/about',
		})
	},

	// //上拉加载更多订单
	// onReachBottom: function () {
	// 	if (!this.data.isLoadedAll) {
	// 		this.data.pageIndex++;
	// 		this._getAllOrders();
	// 	}
	// },
    /**
     * 用户点击右上角分享
     */
	onShareAppMessage: function () {

	}
})
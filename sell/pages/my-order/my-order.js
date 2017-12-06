// my-order.js

import { Address } from '../../utils/address.js';
import { Order } from '../order/order-model.js';
import { My } from '../my/my-model.js';

var address = new Address();
var order = new Order();
var my = new My();

Page({

    /**
     * 页面的初始数据
     */
	data: {
		loadingHidden: false,
		pageIndex: 1,
		orderArr: [],
		isLoadedAll: false   //是否已经全部加载完毕
	},

    /**
     * 生命周期函数--监听页面加载
     */
	onLoad: function (options) {
		this._loadData();
	},
	 
	//加载数据
	_loadData: function () {
		this._getAllOrders();
	},

	//获取所有订单信息
	_getAllOrders: function (callback) {
		order.getOrders(this.data.pageIndex, (res) => {
			var data = res.data;
			if (data.length > 0) {
				this.data.orderArr.push.apply(this.data.orderArr, data);
				this.setData({
					orderArr: this.data.orderArr,
					loadingHidden: true
				})
			} else {
				//已经全部加载完
				this.data.isLoadedAll = true;
			}
			callback && callback();
		})
	},

	//进入订单详情
	showOrderDetailInfo: function (options) {
		var id = order.getDataSet(options, 'id');
		var type = order.getDataSet(options, 'type');
		if(type==null||type==undefined||type==''){
			//传统商品
			wx.navigateTo({
				url: '../order-detail/orderDetail?id=' + id,
			})
		}else{
			console.log(2);
			//预约课程
			wx.navigateTo({
				url: '../order-detail/timeOrderDetail?id=' + id,
			})

		}
	},

	//在订单里面进行二次支付
	_execPay: function (id, index) {
	    var that = this;
	    order.execPay(id, (statusCode) => {
	        if (statusCode > 0) {
	            var flag = statusCode;
	            if (statusCode == 2) {
	                //订单支付成功
	                //更新订单显示状态
	                if (flag) {
	                    that.data.orderArr[index].status = 2;
	                    that.setData({
	                        orrderArr: that.data.orderArr
	                    })
	                }
	            }

	            //跳转到成功、失败页面
	            wx.navigateTo({
	                url: '../pay-result/pay-result?id=' + id + 'flag=' + flag + '&from=my',
	            })
	        } else {
	            that.showTips('支付失败', '商品已下架活库存不足！')
	        }
	    })
	},

	/*下拉刷新页面*/
	onPullDownRefresh: function () {
		this._refresh();
	},

	_refresh: function () {
		var that = this;
		that.data.orderArr = [];  //订单初始化
		that._getAllOrders(() => {
			that.data.isLoadedAll = false;  //是否加载完全
			that.data.pageIndex = 1;
			wx.stopPullDownRefresh();
			order.execSetStorageSync(false);  //更新标志位
		});
	},

	//开锁
	onTestTap: function (options) {
		var id = order.getDataSet(options, 'type');
		var lock = order.getDataSet(options, 'lock');
		var uid = order.getDataSet(options, 'uid');
		console.log(lock);
		wx.navigateTo({
	        url: '../result/result?timeId='+id+'&lock='+lock+'&uid='+uid, 
	    })
	},

    /*
    * 提示窗口
    * params:
    * title - {string}标题
    * content - {string}内容
    * flag - {bool}是否跳转到 "我的页面"
    */
	showTips: function (title, content, flag) {
		wx.showModal({
			title: title,
			content: content,
			showCancel: false,
			success: function (res) {
				if (flag) {
					wx.switchTab({
						url: '/pages/my/my'
					});
				}
			}
		});
	},

    /**
     * 生命周期函数--监听页面初次渲染完成
     */
	onReady: function () {

	},

    /**
     * 生命周期函数--监听页面显示
     */
	onShow: function () {
		var newOrderFlag = order.hasNewOrder();
		if (newOrderFlag) {
			this._refresh();
			wx.getStorageSync('newOrder', false);
		}
	},

    /**
     * 页面上拉触底事件的处理函数
     */
	
	//上拉加载更多订单
	onReachBottom: function () {
		if (!this.data.isLoadedAll) {
			this.data.pageIndex++;
			this._getAllOrders();
		}
	},

    /**
     * 用户点击右上角分享
     */
	// onShareAppMessage: function () {

	// }
})
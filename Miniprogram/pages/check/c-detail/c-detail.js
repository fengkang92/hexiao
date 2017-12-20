// pages/detail/detail.js
import { Detail } from 'detail-model.js';
var detail = new Detail();

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
		var code=options.code;
		this._load(code);
	},
	_load: function (code) {
		detail.getDetail(code, (res) => {
			if(res.code==200){
				var code = res.data.order_no;
				var result = [];
				for (var i = 0, len = code.length; i < len; i += 4) {
					result.push(code.slice(i, i + 4));
				}
				this.setData({
					detail: res.data,
					orderNum: res.data.order_no,
					code: result,
					orderStatus: res.data.status
				})
			}else{
				wx.showModal({
					title: '提示',
					showCancel: false,
					content: '该票不存在，请核对票号！',
					success: function () {
						wx.navigateBack({
							url: '../c-menu/c-menu',
						})
					 },
				})

			}
		})
	},
	//确认验票
	forSure:function(){
		var that=this;
		var orderNum = this.data.orderNum;
		var status = 3;
		var uid = wx.getStorageSync('uid');
		detail.forSure(orderNum, status, uid,(res)=>{
			if (res.code==200||res.code==201){
				//验票通过
				wx.showModal({
					title: '提示',
					showCancel:false,
					content: '验票通过！',
					success:function(){},
				})
				that.setData({
					orderStatus:3
				})
			}
		})
	},
	//revise恢复可用
	revise:function(){
		var that = this;
		var orderNum = this.data.orderNum;
		var status = 2;
		var uid = wx.getStorageSync('uid');
		detail.forSure(orderNum, status, uid, (res) => {
			if (res.code == 200 || res.code == 201) {
				//验票通过
				wx.showModal({
					title: '提示',
					showCancel: false,
					content: '该票已恢复使用！',
					success: function () { },
				})
				that.setData({
					orderStatus: 2
				})
			}
		})
	},
	//delete作废
	delete:function(){
		var that = this;
		var orderNum = this.data.orderNum;
		var status = 4;
		var uid = wx.getStorageSync('uid');
		detail.forSure(orderNum, status, uid, (res) => {
			if (res.code == 200 || res.code == 201) {
				//验票通过
				wx.showModal({
					title: '提示',
					showCancel: false,
					content: '该票已作废！',
					success: function () { },
				})
				that.setData({
					orderStatus: 4
				})
			}
		})
	}

})
// pages/input/input.js
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
		if (this.data.code){
			//后台
			wx.redirectTo({
				url: '../detail/detail',
			})
		}
	},

	/**
	 * 用户点击右上角分享
	 */
	onShareAppMessage: function () {

	}
})
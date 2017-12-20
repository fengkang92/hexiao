// pages/search/search.js
Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		word: null,
	},

	/**
	 * 生命周期函数--监听页面加载
	 */
	onLoad: function (options) {

	},
	codeInput: function (e) {
		this.setData({
			word: e.detail.value
		})
	},
	searchTap: function () {
		if (this.data.word) {
			//houtai
			wx.navigateTo({
				url: '../search-list/search-list',
			})
		} else {
			wx.showModal({
				title: '提示',
				content: '请输入搜索内容！',
				showCancel: false,
				success: function (res) {
					if (res.confirm) {
						console.log('用户点击确定')
					} else if (res.cancel) {
						console.log('用户点击取消')
					}
				}
			})
		}
	},


})
// pages/list/list.js
Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		currentTabsIndex: 0,
	},

	/**
	 * 生命周期函数--监听页面加载
	 */
	onLoad: function (options) {

	},
	//tab切换
	ontabChange: function (event) {
		var index = event.currentTarget.dataset['index'];
		this.setData({
			currentTabsIndex: index
		});
	},
	//搜索
	searchTap:function(){
		wx.navigateTo({
			url: '../search/search',
		})
	},
	//点击查看详情
	itemTap: function () {
		wx.navigateTo({
			url: '../search-detail/search-detail',
		})
	}
})
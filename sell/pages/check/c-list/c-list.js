// pages/list/list.js
import { List } from 'list-model.js';
var list = new List();

Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		currentTabsIndex: 0,
		pageIndex:0,
	},

	/**
	 * 生命周期函数--监听页面加载
	 */
	onLoad: function (options) {
		this._load();
	},
	_load:function(){
		var uid = wx.getStorageSync('uid');
		console.log(uid)
		list.getOrderList(uid,(res)=>{
			console.log(res);
			this.setData({
				pageIndex: res.current_page,
				orderArr:res.data
			})
		})
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
			url: '../c-search/c-search',
		})
	},
	//点击查看详情
	itemTap: function (event) {
		var id = list.getDataSet(event,'id');
		wx.navigateTo({
			url: '../c-search-detail/c-search-detail?id='+id,
		})
	}
})
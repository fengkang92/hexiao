// pages/menu/menu.js
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

	},

	//扫码
	onQrTap: function () {
		// 只允许从相机扫码
		wx.scanCode({
			onlyFromCamera: true,
			success: (res) => {
				console.log(res);
				var code=res.result;
			}
		})
	},
	//输入票号
	onNumTap: function () {
		wx.navigateTo({
			url: '../input/input',
		})
	},
	//验票记录
	onListTap: function () {
		wx.navigateTo({
			url: '../list/list',
		})
	},
	//切换到C端
	onChangeTap: function () {
		wx.navigateToMiniProgram({
			appId: 'wxb489506e9a167248',
			path: 'pages/item/home',
			envVersion: 'release',
			success(res) {
				// 打开成功
			},
			fail: function () {
				wx.showModal({
					title: '黑弧文艺社',
					content: '系统错误，请稍后重试！',
					showCancel: false,
					success: function (res) {

					}
				});
			}
		})
	},

	/**
	 * 用户点击右上角分享
	 */
	onShareAppMessage: function () {

	}
})
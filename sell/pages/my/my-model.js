import { Base } from '../../utils/base.js'

class My extends Base {
	constructor() {
		super()
	}

	// 得到用户微信信息
	getUserInfo(callBack) {
		var that = this;
		// wx.login({
		// 	success: function () {
				wx.getUserInfo({
					success: function (res) {
						typeof callBack == "function" && callBack(res)
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
														typeof callBack == "function" && callBack(res)

														// var userInfo = res.userInfo;
														// this.setData({
														// 	nickName: userInfo.nickName,
														// 	avatarUrl: userInfo.avatarUrl,
														// })
													}
												})
											}
										}, fail: function (res) {
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

	};
	//向后台传递用户数据
	postData(param, callback) {
		var param = {
			url: 'users/user_info',
			type: "post",
			data: { info: param },
			sCallback: function (data) {
				callback && callback(data);
			}
		};
		this.request(param);
	}

}
export { My }
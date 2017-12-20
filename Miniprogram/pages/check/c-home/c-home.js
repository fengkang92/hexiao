// home.js

import { Home } from 'home-model.js';
var home = new Home();


Page({

    /**
     * 页面的初始数据
     */
    data: {
		userName:null,
		passWord:null
    },
	onLoad:function(){

	},
	userNameInput:function(e){
		this.setData({
			userName: e.detail.value
		})
	},
	userPassInput: function (e) {
		this.setData({
			passWord: e.detail.value
		})
	},

	login:function(){
		if (this.data.userName && this.data.passWord){
			home.check(this.data.userName, this.data.passWord,(res)=>{
				console.log(res);
				if (res.code == 200){
					var uid = res.data.id;
					wx.setStorageSync('uid', uid);
					wx.redirectTo({
						url: '../c-menu/c-menu',
					})
				}else{
					wx.showModal({
						title: '提示',
						content: res.msg,
						showCancel: false,
						success: function (res) {
							return;
						}
					})
				}
			})

		}else{
			wx.showModal({
				title: '提示',
				content: '请输入账号密码！',
				showCancel:false,
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


	//跳转到用户小程序
	change:function(){
		wx.switchTab({
			url: '../../home/home',
		})
	}
})
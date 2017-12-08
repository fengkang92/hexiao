// home.js

import { Home } from 'home-model.js';
var home = new Home();
//引入全局变量
import { Config } from "../../utils/config.js";

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
					wx.navigateTo({
						url: '../menu/menu',
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
	jumpToJoy:function(){
		wx.navigateToMiniProgram({
			appId: 'wxb489506e9a167248',
			path: 'pages/item/home',
			envVersion: 'release',
			success(res) {
				// 打开成功
			},
			fail:function(){
				wx.showModal({
					title: '黑弧文艺社',
					content: '系统错误，请稍后重试！',
					showCancel: false,
					success: function (res) {

					}
				});
			}
		})
	}
})
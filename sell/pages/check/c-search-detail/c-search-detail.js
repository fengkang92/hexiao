// pages/detail/detail.js
import { Detail } from '../c-detail/detail-model.js';
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
		var id = options.id;
		this._load(id);
	},
	_load: function (id) {
		detail.getDetail(id, (res) => {
			console.log(res)
			if (res.code == 200) {
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
			} else {

			}
		})
	}

})
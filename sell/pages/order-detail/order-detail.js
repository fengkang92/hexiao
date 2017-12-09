
import { Order } from '../order/order-model.js';

var order = new Order();

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
	  var id=options.id;
	  this._loadData(id);
  },
  _loadData:function(id){
	  order.getOrderInfoById(id, (res) => {
		  var code = res.order_no;
		  var result = [];
		  for (var i = 0, len = code.length; i < len; i += 4) {
			  result.push(code.slice(i, i + 4));
		  }
		  this.setData({
			  code: result,
			  id:res.id,
			  order:res,
		  })
	  })
  },
  pay:function(){
	  this._execPay(this.data.id)
  },
  /*
*开始支付
* params:
* id - {int}订单id
*/
  _execPay: function (id) {
	  if (!order.onPay) {
		  this.showTips('支付提示', '本产品仅用于演示，支付系统已屏蔽', true);//屏蔽支付，提示
		  return;
	  }
	  var that = this;
	  order.execPay(id, (statusCode) => {
		  //1未支付，2已支付,0未生成订单
		  if (statusCode != 0) {
			  var flag = statusCode == 2;
			  wx.redirectTo({
				  url: '../pay-result/pay-result?id=' + id + '&flag=' + flag + '&from=order'
			  });
		  }else{
			  wx.showModal({
				  title: '达雅文化',
				  content: '系统错误，请稍后再试！',
				  showCancel: false,
				  success: function (res) {
					  wx.switchTab({
						  url: '../home/home'
					  })
				  }
			  })
		  }
	  });
  },
  //查看二维码
  onShowImage: function (event) {
	  var src = event.currentTarget.dataset.src;
	  wx.previewImage({
		  current: src, // 当前显示图片的http链接
		  urls: [src] // 需要预览的图片http链接列表
	  })
  },

})

import { Order } from '../order/order-model.js';
// import { Cart } from '../cart/cart-model.js';
// import { Address } from '../../utils/address.js';

var order = new Order();
// var cart = new Cart();
// var address = new Address();

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
		  console.log(res);
		  this.setData({
			  id:res.id,
			  orderInfo:res,
			  address: res.snap_address,
			  item: res.snap_items[0]
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
			//   wx.showModal({
			// 	  title: '黑弧文艺社',
			// 	  content: '正在开放中，敬请期待...',
			// 	  showCancel: false,
			// 	  success: function (res) {
			// 		  wx.switchTab({
			// 			  url: '../home/home'
			// 		  })
			// 	  }
			//   })
		  }
	  });
  },

})
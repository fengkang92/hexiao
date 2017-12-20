import { Order } from '../order/order-model.js';

var order = new Order();

Page({
	data: {
		id:null,
		num:1,        //用户购买数量
		productPrice: 0,    //商品单价
		sumMoney: 0,     //用户选择数量后总价
		orderStatus: 0,   //订单状态状态 1待支付 2待使用 3已使用 4已作废
		name:null,
		mobile:null
	},

    /*
    * 订单数据来源包括两个：
    * 1.直接下单
    * 2.旧的订单5
    * */
	onLoad: function (options) {
		this._fromProduct(options.productId);
	},
	//从商品详情过来
	_fromProduct: function (pid) {
		//获取商品详情
		var that = this;
		order.getProductInfo(pid, (res) => {
			//设置size数组
			this.setData({
				id:res.id,
				order:res,
				sumMoney: res.price * Number(this.data.num),
				productPrice: res.price
			})
		})
	},

	//减少商品数量
	pickDown: function (e) {
		let multiple = 100;
		var num=this.data.num;
		if(num>1){
			num--;
			let sumMoney = Number(this.data.productPrice) * multiple * Number(num) * multiple;
			this.setData({
				num:num,
				sumMoney: sumMoney / (multiple * multiple)
			})
		}
	},
	//增加商品数量
	pickAdd: function (e) {
		let multiple = 100;
		var num = this.data.num;
		num++;
		let sumMoney = Number(this.data.productPrice) * multiple * Number(num) * multiple;
		this.setData({
			num: num,
			sumMoney: sumMoney / (multiple * multiple)
		})
	},

	//获取用户姓名
	bindNameInput: function (e) {
		this.setData({
			name: e.detail.value
		})
	},

	//获取用户手机号
	bindMobileInput: function (e) {
		this.setData({
			mobile: e.detail.value
		})
	},

	/*下单和付款*/
	pay: function () {
		if (this.data.name &&this.data.mobile) {
			if (!(/^1[34578]\d{9}$/.test(this.data.mobile))) {
				wx.showModal({
					title: '下单提示',
					content: '手机号码有误！',
					showCancel: false,
					success: function (res) {
						return;
					}
				})
			}else{
				this._firstTimePay();
			}
		}else{
			wx.showModal({
				title: '下单提示',
				content: '请填写您的姓名和手机号！',
				showCancel: false,
				success: function (res) {
					return;
				}
			})
		}
	},

	/*第一次支付*/
	_firstTimePay: function () {
		//将要发送的订单数据数组下标转化为具体值
		var orderInfo = [{}];
		orderInfo[0]['product_id'] = this.data.id;		//商品id
		orderInfo[0]['count'] = this.data.num;		//数量
		orderInfo[0]['parameterA'] = this.data.name;	//规格
		orderInfo[0]['parameterB'] = this.data.mobile;		//快递方式 
		orderInfo[0]['type'] = 0;							//固定为0		
		this.doOrder(orderInfo);
	},
	//支付
	doOrder: function (orderInfo){
		console.log(orderInfo)
		var that = this;
		// 支付分两步，第一步是生成订单号，然后根据订单号支付
		order.doOrder(orderInfo, (data) => {
			console.log(data);
			this.data.orderId = data.order_id;
			//订单生成成功
			if (data.pass) {
				//更新订单状态
				var id = data.order_id;
				that.data.orderId = id;
				that.data.fromProductFlag = false;
				//开始支付
				that._execPay(id);
			} else {
				that._orderFail(data);  // 下单失败
			}
		});
	},
    /*
    *下单失败
    * params:
    * data - {obj} 订单结果信息
    * */
	_orderFail: function (data) {
		this.setData({
			isCanPay: false
		})
		var str = this.data.order.name;
		str += ' 缺货';
		wx.showModal({
			title: '下单失败',
			content: str,
			showCancel: false,
			success: function (res) {

			}
		});
	},

	/* 再次次支付*/
	_oneMoresTimePay: function () {
		this._execPay(this.data.orderId);
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
			}
		});
	},

	onShow: function () {
	},

})

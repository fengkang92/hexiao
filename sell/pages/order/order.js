import { Order } from '../order/order-model.js';
import { Cart } from '../cart/cart-model.js';
import { Address } from '../../utils/address.js';

var order = new Order();
var cart = new Cart();
var address = new Address();

Page({
	data: {
		id:null,
		countsArray: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
		countValue: null,
		featureArray: [],
		featureValue: null,
		shipArray: ['门店自提', '第三方快递'],
		shipValue: null,
		productPrice: 0,    //商品单价
		sumMoney: 0,     //用户选择数量后总价
		addressInfo: null,
		isShip: true,		//是否显示运费
		orderStatus: 0,   //订单状态，0还未生成订单，刚从商品详情过来，可以修改地址，1未支付，2已支付
		isCanPay: true,
		ship: '免运费',    //运费,用于UI显示
		shipPrice: 0,    //商品运费,用于计算总价
	},

    /*
    * 订单数据来源包括两个：
    * 1.直接下单
    * 2.旧的订单5
    * */
	onLoad: function (options) {
		var from = options.from;
		if (from == 'product') {
			this._fromProduct(options.productId);
			this.setData({
				orderStatus: 0
			})
		} else {
			this._fromOrder(options.OrderId);
		}
	},
	//从商品详情过来
	_fromProduct: function (pid) {
		//获取商品详情
		var that = this;
		order.getProductInfo(pid, (res) => {
			console.log(res);
			//设置size数组
			this.setData({
				id:res.id,
				featureArray: this._getProductFeature(res),
				productDetailInfo: res,
				productPrice: res.price,
				ship: res.ship,
				shipPrice: res.shipPrice ? res.shipPrice:0
			})
		})
		/*显示收获地址*/
		address.getAddress((res) => {
			this._bindAddressInfo(res);
		});
	},
	//从订单列表过来
	_fromOrder: function () {

	},
	//获取商品样式
	_getProductFeature: function (res) {
		var arr = [];
		for (let i = 0; i < res.feature.length; i++) {
			var detail = res.feature[i].feature;
			arr.push(detail);
		}
		return arr;
	},

	//选择商品数量
	bindPickerCount: function (e) {
		var val = e.detail.value;
		this.setData({
			countValue: this.data.countsArray[val],
		})
		//选择完数量计算价格
		let multiple = 100;
		let sumMoney = Number(this.data.countsArray[val]) * multiple * Number(this.data.productPrice) * multiple;
		//选择完之后更新价格
		this.setData({
			sumMoney: sumMoney / (multiple * multiple) + this.data.shipPrice
		})
	},

	//选择商品规格
	bindPickerFeature: function (e) {
		var val = e.detail.value;
		this.setData({
			featureValue: this.data.featureArray[val],
		})
	},

	//选择配送方式
	bindPickerShip: function (e) {
		var val = e.detail.value;
		this.setData({
			shipValue: this.data.shipArray[val],
		})
		if (val == 0) {
			//门店自提
			this.setData({
				isShip: true
			})
		} else {
			//第三方快递
			this.setData({
				isShip: false
			})
		}

	},

	/*下单和付款*/
	pay: function () {
		if (!this.data.addressInfo) {
			this.showTips('下单提示', '请填写您的收货地址');
			return;
		}
		if (this.data.orderStatus == 0) {
			this._firstTimePay();
		} else {
			this._oneMoresTimePay();
		}
	},

	/*第一次支付*/
	_firstTimePay: function () {
		//将要发送的订单数据数组下标转化为具体值
		var orderInfo = [{}];
		orderInfo[0]['product_id'] = this.data.id;		//商品id
		orderInfo[0]['count'] = this.data.countValue;		//数量
		orderInfo[0]['parameterA'] = this.data.featureValue ? this.data.featureValue:'';	//规格
		orderInfo[0]['parameterB'] = this.data.shipValue;		//快递方式 
		orderInfo[0]['type'] = 0;							//固定为0		

		if (this.data.featureArray.length > 0){

			if (this.data.featureValue && this.data.countValue && this.data.shipValue){
				this.doOrder(orderInfo);
			}else{
				wx.showModal({
					title: '黑弧文艺社',
					content: '请选择商品信息！',
					showCancel: false,
					success: function (res) {
						return;
					}
				})
			}

		}else{

			if (this.data.countValue && this.data.shipValue){
				this.doOrder(orderInfo);
			}else{
				wx.showModal({
					title: '黑弧文艺社',
					content: '请选择商品信息！',
					showCancel: false,
					success: function (res) {
						return;
					}
				})
			}
		}
	},
	//支付
	doOrder: function (orderInfo){
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
		var str = this.data.productDetailInfo.name + this.data.productDetailInfo.describe;
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

	/*修改或者添加地址信息*/
	editAddress: function () {
		console.log('editAddress')
		var that = this;
		wx.chooseAddress({
			success: function (res) {
				var addressInfo = {
					name: res.userName,
					mobile: res.telNumber,
					totalDetail: address.setAddressInfo(res)
				};
				that._bindAddressInfo(addressInfo);

				//保存地址
				address.submitAddress(res, (flag) => {
					if (!flag) {
						that.showTips('操作提示', '地址信息更新失败！');
					}
				});
			}
		})
	},

	/*绑定地址信息*/
	_bindAddressInfo: function (addressInfo) {
		this.setData({
			addressInfo: addressInfo
		});
	},


    /*
    * 提示窗口
    * params:
    * title - {string}标题
    * content - {string}内容
    * flag - {bool}是否跳转到 "我的页面"
    */
	showTips: function (title, content, flag) {
		wx.showModal({
			title: title,
			content: content,
			showCancel: false,
			success: function (res) {
				if (flag) {
					wx.switchTab({
						url: '/pages/my/my'
					});
				}
			}
		});
	}



})

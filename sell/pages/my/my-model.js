import { Base } from '../../utils/base.js'

class My extends Base {
	constructor() {
		super()
	}

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
	//获取订单列表
	getOrders(pageIndex, callback) {
		var allParams = {
			url: 'order/by_user',
			data: { page: pageIndex },
			type: 'get',
			sCallback: function (data) {
				callback && callback(data);  //1 未支付  2，已支付  3，已发货，4已支付，但库存不足
			}
		};
		this.request(allParams);
	}
	/*获得订单的具体内容*/
	getOrderInfoById(id, callback) {
		var that = this;
		var allParams = {
			url: 'order/' + id,
			sCallback: function (data) {
				callback && callback(data);
			},
			eCallback: function () {

			}
		};
		this.request(allParams);
	}

}
export { My }
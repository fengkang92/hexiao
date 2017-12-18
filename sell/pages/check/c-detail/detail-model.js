
import { Base } from '../../../utils/base.js';

class Detail extends Base {

	constructor() {
		super();
	}
	//通过二维码获取订单详情
	getDetail(id, callback) {
		var param = {
			url: 'order/by_checker/' + id,
			sCallback: function (data) {
				callback && callback(data);
			}
		}
		this.request(param);
	}
	//确认验票
	forSure(orderNum, status, uid, callback){
		var param = {
			url: 'order/check_status?order_no='+orderNum+'&status='+status+'&admin_id=' + uid,
			sCallback: function (data) {
				callback && callback(data);
			}
		}
		this.request(param);
	}

}
export { Detail };
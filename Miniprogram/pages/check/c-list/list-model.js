
import { Base } from '../../../utils/base.js';

class List extends Base {

	constructor() {
		super();
	}
	getOrderList(uid, callback) {
		var param = {
			url: 'order/by_user?admin_id=' + uid,
			sCallback: function (data) {
				callback && callback(data);
			}
		}
		this.request(param);

	}
}
export { List };
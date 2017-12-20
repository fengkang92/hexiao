// pages/check/c-menu/menu-model.js.js

import { Base } from '../../../utils/base.js';

class Menu extends Base {

	constructor() {
		super();
	}
	//
	getDetail(id) {
		var param = {
			url: 'order/by_checker/' + id,
			sCallback: function (data) {
				callback && callback(data);
			}
		}
		this.request(param);

	}
}
export { Menu };
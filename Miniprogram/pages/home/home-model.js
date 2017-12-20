
import { Base } from '../../utils/base.js';

class Home extends Base {

	constructor() {
		super();
	}

	getProductsData(callback) {
		var param = {
			url: 'platform/shoplist',
			sCallback: function (data) {
				callback && callback(data);
			}
		}
		this.request(param);

	}

}
export { Home };
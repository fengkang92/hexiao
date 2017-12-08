
import { Base } from '../../utils/base.js';

class Home extends Base {

	constructor() {
		super();
	}
	check(name, pwd, callback) {
		var param = {
			url: 'login?name=' + name + '&pwd=' + pwd,
			sCallback: function (data) {
				callback && callback(data);
			}
		}
		this.request(param);

	}
}
export { Home };

import { Base } from '../../utils/base.js';

class Product extends Base {
    constructor() {
        super();
    }
	//获取传统商品详情
    getProductInfo(id, callback) {
        var param = {
			url: 'platform/shopDetails?id=' + id,
            sCallback: function (data) {
                callback && callback(data);
            }
        };
        this.request(param);
    }  
};

export { Product }

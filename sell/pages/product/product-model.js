
import { Base } from '../../utils/base.js';

class Product extends Base {
    constructor() {
        super();
    }
	//获取传统商品详情
    getProductInfo(id, callback) {
        var param = {
            url: 'product/' + id,
            sCallback: function (data) {
                callback && callback(data);
            }
        };
        this.request(param);
    }

    //获取传统商品当前分类下推荐商品（商品前5个）
	getMoreByCategory(id,summary, callback) {
		console.log(id, summary)
		var param = {
			url: 'product/by_category?id=' + id + '&summary=' + summary,
			sCallback: function (data) {
				callback && callback(data);
			}
		};
		this.request(param);
	}
   
};

export { Product }

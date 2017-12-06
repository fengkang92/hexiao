import { Order } from '../order/order-model.js';
import { Cart } from '../cart/cart-model.js';
import { Address } from '../../utils/address.js';

var order = new Order();
var cart = new Cart();
var address = new Address();

Page({
  data: {
    fromCartFlag: true,
    addressInfo: null
  },

  /*
  * 订单数据来源包括两个：
  * 1.购物车下单
  * 2.旧的订单
  * */
  onLoad: function (options) {
    var flag = options.from == 'cart',
      that = this;
    this.data.fromCartFlag = flag;
    this.data.account = options.account;

    //来自于购物车
    if (flag) {
      this.setData({
        productsArr: cart.getCartDataFromLocal(true),
        account: options.account,
        orderStatus: 0
      });

      /*显示收获地址*/
      address.getAddress((res) => {
        that._bindAddressInfo(res);
      });
    }

    //旧订单
    else {
      this.data.id = options.id;
    }
  },

  onShow: function () {
    if (this.data.id) {
      var that = this;
      //下单后，支付成功或者失败后，点左上角返回时能够更新订单状态 所以放在onshow中
      var id = this.data.id;
      order.getOrderInfoById(id, (data) => {
        that.setData({
          orderStatus: data.status,
          productsArr: data.snap_items,
          account: data.total_price,
          basicInfo: {
            orderTime: data.create_time,
            orderNo: data.order_no
          },
        });

        // 快照地址
        var addressInfo = data.snap_address;
        addressInfo.totalDetail = address.setAddressInfo(addressInfo);
        that._bindAddressInfo(addressInfo);
      });
    }

    var cartData = this.getCartDataFromLocal();
    var cal = this._calcTotalAccountAndCounts(cartData);
    this.setData({
      account: cal.account,
      cartData: cartData
    });

  },

  /*
  * 从缓存中读取购物车数据
  */
  getCartDataFromLocal(flag) {
    var res = wx.getStorageSync('cart');
    if (!res) {
      res = [];
    }

    //在下单的时候过滤不下单的商品，
    if (flag) {
      var newRes = [];
      for (let i = 0; i < res.length; i++) {
        if (res[i].selectStatus) {
          newRes.push(res[i]);
        }
      }
      res = newRes;
    }

    return res;
  },

  _calcTotalAccountAndCounts: function (data) {
    var len = data.length,

      // 所需要计算的总价格，但是要注意排除掉未选中的商品
      account = 0;

    let multiple = 100;

    for (let i = 0; i < len; i++) {
      //避免 0.05 + 0.01 = 0.060 000 000 000 000 005 的问题，乘以 100 *100
      account += data[i].counts * multiple * Number(data[i].price) * multiple;
    }

    return {
      account: account / (multiple * multiple)
    }
  },

  /*修改或者添加地址信息*/
  editAddress: function () {
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
    var orderInfo = [],
      procuctInfo = this.data.productsArr,
      order = new Order();
    for (let i = 0; i < procuctInfo.length; i++) {
      orderInfo.push({
        product_id: procuctInfo[i].id,
        count: procuctInfo[i].counts
      });
    }

    var that = this;
    //支付分两步，第一步是生成订单号，然后根据订单号支付
    order.doOrder(orderInfo, (data) => {
      //订单生成成功
      if (data.pass) {
        //更新订单状态
        var id = data.order_id;
        that.data.id = id;
        that.data.fromCartFlag = false;

        //开始支付
        that._execPay(id);
      } else {
        that._orderFail(data);  // 下单失败
      }
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
  },

  /*
  *下单失败
  * params:
  * data - {obj} 订单结果信息
  * */
  _orderFail: function (data) {
    var nameArr = [],
      name = '',
      str = '',
      pArr = data.pStatusArray;
    for (let i = 0; i < pArr.length; i++) {
      if (!pArr[i].haveStock) {
        name = pArr[i].name;
        if (name.length > 15) {
          name = name.substr(0, 12) + '...';
        }
        nameArr.push(name);
        if (nameArr.length >= 2) {
          break;
        }
      }
    }
    str += nameArr.join('、');
    if (nameArr.length > 2) {
      str += ' 等';
    }
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
    this._execPay(this.data.id);
  },

  /*
  *开始支付
  * params:
  * id - {int}订单id
  */
  _execPay: function (id) {
    if (!order.onPay) {
      this.showTips('支付提示', '本产品仅用于演示，支付系统已屏蔽', true);//屏蔽支付，提示
      this.deleteProducts(); //将已经下单的商品从购物车删除
      return;
    }
    var that = this;
    order.execPay(id, (statusCode) => {
      if (statusCode != 0) {
        that.deleteProducts(); //将已经下单的商品从购物车删除   当状态为0时，表示

        var flag = statusCode == 2;
        wx.navigateTo({
          url: '../pay-result/pay-result?id=' + id + '&flag=' + flag + '&from=order'
        });
      }
    });
  },

  //将已经下单的商品从购物车删除
  deleteProducts: function () {
    var ids = [], arr = this.data.productsArr;
    for (let i = 0; i < arr.length; i++) {
      ids.push(arr[i].id);
    }
    cart.delete(ids);
  },

  /*根据商品id得到 商品所在下标*/
  _getProductIndexById: function (id) {
    var data = this.data.cartData,
      len = data.length;
    for (let i = 0; i < len; i++) {
      if (data[i].id == id) {
        return i;
      }
    }
  },

  /*删除商品*/
  delete: function (event) {
    var id = cart.getDataSet(event, 'id'),
      index = this._getProductIndexById(id);
    console.log(id);
    this.data.cartData.splice(index, 1);//删除某一项商品

    this._resetCartData();
    //this.toggleSelectAll();

    cart.delete(id);  //内存中删除该商品
  },

  /*更新购物车商品数据*/
  _resetCartData: function () {
    var newData = this._calcTotalAccountAndCounts(this.data.cartData); /*重新计算总金额和商品总数*/
    this.setData({
      account: newData.account,
      cartData: this.data.cartData
    });
  },

  /*
    * 计算总金额和选择的商品总数
    * */
  _calcTotalAccountAndCounts: function (data) {
    var len = data.length,
      account = 0,
      selectedCounts = 0,
      selectedTypeCounts = 0;
    let multiple = 100;
    for (let i = 0; i < len; i++) {
      //避免 0.05 + 0.01 = 0.060 000 000 000 000 005 的问题，乘以 100 *100
      if (data[i].selectStatus) {
        account += data[i].counts * multiple * Number(data[i].price) * multiple;
        selectedCounts += data[i].counts;
        selectedTypeCounts++;
      }
    }
    return {
      selectedCounts: selectedCounts,
      selectedTypeCounts: selectedTypeCounts,
      account: account / (multiple * multiple)
    }
  },


}
)
<?php
/**
 * 路由注册
 *
 * 以下代码为了尽量简单，没有使用路由分组
 * 实际上，使用路由分组可以简化定义
 * 并在一定程度上提高路由匹配的效率
 */

// 写完代码后对着路由表看，能否不看注释就知道这个接口的意义
use think\Route;

//接口
//1. 场馆列表
Route::get('api/:version/venue/venueList', 'api/:version.Venue/getVenueList');
//2. 场馆经纬度
Route::get('api/:version/gymnasium/longitude_latitude', 'api/:version.gymnasium/getLongitudeLatitudeByUser');
//4. 场馆详情
Route::get('api/:version/gymnasium/:id', 'api/:version.gymnasium/getDetail',[], ['id'=>'\d+']);
//3. 预约课程列表
Route::get('api/:version/course/by_user', 'api/:version.course/getSummaryByUser');
//5. 课程详情
Route::get('api/:version/course/:id', 'api/:version.course/getDetail',[], ['id'=>'\d+']);
//6. 收藏
Route::get('api/:version/favourite/collect', 'api/:version.favourite/getCollectByUser');
//7. 取消收藏
Route::get('api/:version/favourite/cancel', 'api/:version.favourite/getCancelByUser');
//8. 收藏列表
Route::get('api/:version/favourite/by_user', 'api/:version.favourite/getSummaryByUser');
//9. 订单列表
//10. 订单详情
//11. 下单
//Order
Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order/:id', 'api/:version.Order/getDetail',[], ['id'=>'\d+']);
Route::get('api/:version/order/check_status', 'api/:version.Order/checkOrderStatus');
Route::get('api/:version/order/by_checker/:order_no', 'api/:version.Order/getDetailByChecker');
Route::put('api/:version/order/delivery', 'api/:version.Order/delivery');

//不想把所有查询都写在一起，所以增加by_user，很好的REST与RESTFul的区别
Route::get('api/:version/order/by_user', 'api/:version.Order/getSummaryByUser');
Route::get('api/:version/order/paginate', 'api/:version.Order/getSummary');
Route::get('api/:version/order/generateOrder', 'api/:version.Order/generateOrder');
Route::get('api/:version/order/getOrder', 'api/:version.Order/getOrder');
//12. 支付
//Pay
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');
Route::post('api/:version/pay/re_notify', 'api/:version.Pay/redirectNotify');
Route::post('api/:version/pay/concurrency', 'api/:version.Pay/notifyConcurrency');


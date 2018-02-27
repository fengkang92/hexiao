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
//Route::get('api/:version/gymnasium/longitude_latitude', 'api/:version.gymnasium/getLongitudeLatitudeByUser');
//4. 场馆详情
Route::get('api/:version/venue/:id', 'api/:version.venue/getVenueDetails',[], ['id'=>'\d+']);
//3. 预约课程列表
Route::get('api/:version/course/courseTimeList', 'api/:version.Course/courseTimeList');
//5. 课程详情
Route::get('api/:version/course/:id', 'api/:version.Course/getDetail',[], ['id'=>'\d+']);
//6. 预约课程详情
Route::get('api/:version/course/courseData', 'api/:version.Course/reservedCourseDetails');
Route::get('api/:version/course/courseHot', 'api/:version.Course/CourseHot');
//7. 收藏
Route::get('api/:version/collection/collect', 'api/:version.Collection/collectByUser');
//8. 取消收藏
Route::get('api/:version/collection/cancel', 'api/:version.Collection/cancelCollect');
//9. 收藏列表
Route::get('api/:version/collection/collectionList', 'api/:version.Collection/collectionList');
//搜索
Route::get('api/:version/search', 'api/:version.Search/getSearchInfo');

//秒杀
Route::get('api/:version/seckill/lists', 'api/:version.Seckill/seckillList');

//10. 订单列表
//11. 订单详情
//12. 下单
//12. 支付
//Sample
//Route::get('api/:version/sample/:key', 'api/:version.Sample/getSample');
Route::get('api/:version/sample/sms', 'api/:version.Sample/sendSMS');
Route::get('api/:version/sample/test4', 'api/:version.Sample/test4');

//Token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/token/app', 'api/:version.Token/getAppToken');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

//Users
Route::post('api/:version/users/user_info', 'api/:version.Users/addUserInfo');

//Address
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');
Route::get('api/:version/address', 'api/:version.Address/getUserAddress');

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

//Pay
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');
Route::post('api/:version/pay/re_notify', 'api/:version.Pay/redirectNotify');
Route::post('api/:version/pay/concurrency', 'api/:version.Pay/notifyConcurrency');

//Message
Route::post('api/:version/message/delivery', 'api/:version.Message/sendDeliveryMsg');



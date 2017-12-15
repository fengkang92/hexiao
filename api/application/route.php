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

Route::get('api/:version/platform/shopDetails', 'api/:version.Platform/shopDetails');
Route::get('api/:version/platform/shoplist', 'api/:version.Platform/shoplist');
Route::get('api/:version/login', 'api/:version.Login/login');

//核销
Route::get('api/:version/writeoff/qrcode', 'api/:version.Writeoff/qrcode');


//Sample
//Route::get('api/:version/sample/:key', 'api/:version.Sample/getSample');
Route::get('api/:version/sample/sms', 'api/:version.Sample/sendSMS');
Route::get('api/:version/sample/test4', 'api/:version.Sample/test4');

//Miss 404
//Miss 路由开启后，默认的普通模式也将无法访问
//Route::miss('api/v1.Miss/miss');

//Banner
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

//Theme
// 如果要使用分组路由，建议使用闭包的方式，数组的方式不允许有同名的key
//Route::group('api/:version/theme',[
//    '' => ['api/:version.Theme/getThemes'],
//    ':t_id/product/:p_id' => ['api/:version.Theme/addThemeProduct'],
//    ':t_id/product/:p_id' => ['api/:version.Theme/addThemeProduct']
//]);

Route::group('api/:version/theme',function(){
    Route::get('', 'api/:version.Theme/getSimpleList');
    Route::get('/:id', 'api/:version.Theme/getComplexOne');
    Route::post(':t_id/product/:p_id', 'api/:version.Theme/addThemeProduct');
    Route::delete(':t_id/product/:p_id', 'api/:version.Theme/deleteThemeProduct');
});

//Route::get('api/:version/theme', 'api/:version.Theme/getThemes');
//Route::post('api/:version/theme/:t_id/product/:p_id', 'api/:version.Theme/addThemeProduct');
//Route::delete('api/:version/theme/:t_id/product/:p_id', 'api/:version.Theme/deleteThemeProduct');

//Product
Route::post('api/:version/product', 'api/:version.Product/createOne');
Route::delete('api/:version/product/:id', 'api/:version.Product/deleteOne');
Route::get('api/:version/product/by_category/paginate', 'api/:version.Product/getByCategory');
Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');
Route::get('api/:version/product/:id', 'api/:version.Product/getOne',[],['id'=>'\d+']);
Route::get('api/:version/product_order/:id', 'api/:version.Product/getOneOrder',[],['id'=>'\d+']);
Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');

//Course预约
Route::get('api/:version/course/curriculum', 'api/:version.Course/getByCategoryCurriculum');
Route::get('api/:version/course/curriculum/details', 'api/:version.Course/getCurriculumData');
Route::get('api/:version/course/reserve', 'api/:version.Course/getReserve');

//卡多宝
Route::get('api/:version/doors/small_program', 'api/:version.Doors/checkWeChat');
Route::get('api/:version/doors/check_other', 'api/:version.Doors/otherUser');
Route::get('api/:version/doors/check_teacher', 'api/:version.Doors/checkTeacher');

//Video
Route::get('api/:version/video/by_category/paginate', 'api/:version.Video/getByCategory');
Route::get('api/:version/video/by_category', 'api/:version.Video/getAllInCategory');
Route::get('api/:version/video/:id', 'api/:version.Video/getOne',[],['id'=>'\d+']);
Route::get('api/:version/video/recent', 'api/:version.Video/getRecent');


//Category
Route::get('api/:version/category', 'api/:version.Category/getCategories'); 
// 正则匹配区别id和all，注意d后面的+号，没有+号将只能匹配个位数
//Route::get('api/:version/category/:id', 'api/:version.Category/getCategory',[], ['id'=>'\d+']);
//Route::get('api/:version/category/:id/products', 'api/:version.Category/getCategory',[], ['id'=>'\d+']);
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');

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

//Pay
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');
Route::post('api/:version/pay/re_notify', 'api/:version.Pay/redirectNotify');
Route::post('api/:version/pay/concurrency', 'api/:version.Pay/notifyConcurrency');

//Message
Route::post('api/:version/message/delivery', 'api/:version.Message/sendDeliveryMsg');



//return [
//        ':version/banner/[:location]' => 'api/:version.Banner/getBanner'
//];

//Route::miss(function () {
//    return [
//        'msg' => 'your required resource are not found',
//        'error_code' => 10001
//    ];
//});



/*
 * 预约平台BOOKING系统第三方接口开发
 * 主要交互数据检测库存
 */


//Sample
//Route::get('api/:version/sample/:key', 'api/:version.Sample/getSample');
Route::get('booking/:version/sample/sms', 'booking/:version.Sample/sendSMS');
Route::get('booking/:version/sample/test4', 'booking/:version.Sample/test4');


//course
Route::post('booking/:version/course_teacher/add','booking/:version.Course/addCourseAndTeracher');
Route::post('booking/:version/course/edit','booking/:version.Course/editAndDelete');


//teacher
Route::post('booking/:version/teacher/edit','booking/:version.Teacher/editAndDelete');
Route::post('booking/:version/teacher/price','booking/:version.Teacher/editPrice');


//time
Route::post('booking/:version/time/add','booking/:version.Time/addServiceTime');
Route::post('booking/:version/time/edit','booking/:version.Time/editAndDelete');


//order
Route::post('booking/:version/order/check_stock','booking/:version.Order/checkTimeStock');
//Route::post('booking/:version/order/lock_stock','booking/:version.Order/lockTimeStock');
Route::post('booking/:version/order/confirm_pay','booking/:version.Order/confirmPayStatus');

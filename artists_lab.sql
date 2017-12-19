/*
 Navicat Premium Data Transfer

 Source Server         : artist
 Source Server Type    : MySQL
 Source Server Version : 50638
 Source Host           : 39.104.60.33
 Source Database       : artists_lab

 Target Server Type    : MySQL
 Target Server Version : 50638
 File Encoding         : utf-8

 Date: 12/18/2017 22:10:21 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `address`
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `country` varchar(20) DEFAULT NULL COMMENT '区',
  `detail` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL COMMENT '盒子地址ID',
  `user_id` int(11) DEFAULT NULL COMMENT '外键',
  `update_time` int(11) DEFAULT NULL,
  `longitude` decimal(14,8) NOT NULL DEFAULT '0.00000000' COMMENT '经度',
  `latitude` decimal(14,8) NOT NULL DEFAULT '0.00000000' COMMENT '纬度',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `adminuser`
-- ----------------------------
DROP TABLE IF EXISTS `adminuser`;
CREATE TABLE `adminuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户表：包括后台管理员、商家会员和普通会员',
  `name` varchar(20) NOT NULL COMMENT '登陆账号',
  `uname` varchar(10) DEFAULT NULL COMMENT '昵称',
  `pwd` varchar(50) NOT NULL COMMENT 'MD5密码',
  `qx` tinyint(4) NOT NULL DEFAULT '5' COMMENT '权限 4超级管理员 5普通管理员2供应商',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  `del` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `supplier_id` int(11) DEFAULT NULL COMMENT '供应商ID',
  `role_id` int(11) DEFAULT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `adminuser`
-- ----------------------------
BEGIN;
INSERT INTO `adminuser` VALUES ('1', 'admin', '超级管理员', '14e1b600b1fd579f47433b88e8d85291', '4', '1375086480', '0', null, null), ('2', 'ceshi', '普通管理员', '14e1b600b1fd579f47433b88e8d85291', '5', '1493262002', '0', null, null), ('3', 'ceshi2', '普通管理员', '550e1bafe077ff0b0b67f4e32f29d751', '5', '1493262042', '0', null, null), ('4', 'test', '普通管理员', '14e1b600b1fd579f47433b88e8d85291', '5', '1498634942', '1', null, null), ('5', 'hxxy2003', '普通管理员', '14e1b600b1fd579f47433b88e8d85291', '5', '1498636731', '0', null, null), ('6', 'fdsafd', '普通管理员', '9055a12518dc6631ab421d03003f0f9c', '5', '1498636738', '0', null, null), ('7', 'fdsafsda', '普通管理员', '07cd3d179cab8fdc94cb3c08766a4713', '5', '1498636758', '0', null, null), ('8', 'asaa', '普通管理员', '4c2f0934fa62306c76a89477e563f7ce', '5', '1498636767', '0', null, null), ('9', 'tretre', '普通管理员', '280179d97a5f8877b93b3537ca69e908', '5', '1498636775', '0', null, null), ('10', 'fdsafdsa', '普通管理员', '07cd3d179cab8fdc94cb3c08766a4713', '5', '1498636786', '0', null, null), ('11', 'fdsafdsafdsa', '普通管理员', '07cd3d179cab8fdc94cb3c08766a4713', '5', '1498636793', '1', null, null), ('12', 'fdsafdsafdsaf', '普通管理员', '36c97f6a8b2beb254581ebb46369a3ae', '5', '1498636810', '1', null, null), ('13', 'yong', '普通管理员', '14e1b600b1fd579f47433b88e8d85291', '5', '1498636810', '1', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `banner`
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) DEFAULT NULL COMMENT 'Banner描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner管理表';

-- ----------------------------
--  Table structure for `banner_item`
-- ----------------------------
DROP TABLE IF EXISTS `banner_item`;
CREATE TABLE `banner_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题',
  `delete_time` int(11) DEFAULT NULL,
  `banner_id` int(11) NOT NULL COMMENT '外键，关联banner表',
  `update_time` int(11) DEFAULT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner子项表';

-- ----------------------------
--  Table structure for `box_course`
-- ----------------------------
DROP TABLE IF EXISTS `box_course`;
CREATE TABLE `box_course` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `chain_id` int(10) unsigned NOT NULL COMMENT '分店ID',
  `category_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型，如钢琴，吉它、瑜珈、美术',
  `interfix` char(8) DEFAULT NULL COMMENT '关联内容',
  `interfix_id` int(11) DEFAULT NULL COMMENT '关联内容对应的ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `device_name` varchar(100) NOT NULL COMMENT '设备名称',
  `address` varchar(255) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL COMMENT '详细介绍',
  `relationship` smallint(6) NOT NULL DEFAULT '1' COMMENT '场景用户上限，1为独占，N为共享 用户数',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '记录修改时间',
  `status` tinyint(4) DEFAULT NULL COMMENT '信息状态：1正常，2禁用，-1删除 ',
  `flag` tinyint(4) DEFAULT '0' COMMENT '审核状态，0待审核，-1审核不通过，1审核通过 ',
  `check_info` tinyint(4) NOT NULL DEFAULT '0' COMMENT '审核不通过理由 ',
  PRIMARY KEY (`sid`),
  KEY `lr_course_interfix_id_Idx` (`interfix_id`,`interfix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='空间服务';

-- ----------------------------
--  Table structure for `box_course_plan`
-- ----------------------------
DROP TABLE IF EXISTS `box_course_plan`;
CREATE TABLE `box_course_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` int(11) DEFAULT '0' COMMENT '第三方对接唯一id',
  `sid` int(10) unsigned NOT NULL COMMENT '空间ID',
  `suppiler_id` int(10) unsigned NOT NULL COMMENT '供应商ID',
  `server_name` varchar(20) NOT NULL COMMENT '服务名称',
  `discribe` varchar(100) DEFAULT NULL COMMENT '副标',
  `section` varchar(100) DEFAULT NULL COMMENT '套课时间',
  `unit` varchar(10) DEFAULT NULL COMMENT '计量单位',
  `advance` int(10) unsigned DEFAULT NULL COMMENT '提前预约时间',
  `types` varchar(30) DEFAULT NULL COMMENT '课程类型',
  `cost` varchar(200) DEFAULT NULL COMMENT '费用包括',
  `prompt` varchar(200) DEFAULT NULL COMMENT '温馨提示',
  `content` text COMMENT '服务介绍',
  `tag` varchar(100) DEFAULT NULL COMMENT '标签',
  `hot` tinyint(4) DEFAULT '0' COMMENT '是否热销1是 0否',
  `main_img_url` varchar(255) DEFAULT NULL COMMENT '课程图片',
  `home_img_url` varchar(255) DEFAULT NULL COMMENT '热销图片',
  `plan_type` tinyint(3) unsigned DEFAULT NULL COMMENT '服务安排0不计划1按天计划2.按周计划3按班计划',
  `status` tinyint(3) unsigned DEFAULT '1' COMMENT '审核状态（1正常2下架-1删除）',
  `check_info` varchar(255) DEFAULT NULL COMMENT '审核不通过理由',
  `create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `from` tinyint(4) DEFAULT '1' COMMENT '类型1本地2第三方',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='空间产品服务计划';

-- ----------------------------
--  Table structure for `box_course_service`
-- ----------------------------
DROP TABLE IF EXISTS `box_course_service`;
CREATE TABLE `box_course_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` int(11) DEFAULT '0' COMMENT '第三方对接唯一id',
  `course_plan_id` int(10) unsigned NOT NULL COMMENT '产品服务计划ID',
  `sid` int(10) unsigned NOT NULL COMMENT '空间ID',
  `supplier_id` int(10) unsigned NOT NULL COMMENT '供应商ID',
  `server_name` varchar(100) NOT NULL COMMENT '服务名称',
  `experience` varchar(100) DEFAULT NULL COMMENT '教龄1-10年、10年以上',
  `students` varchar(100) DEFAULT NULL COMMENT '适合学员：零基础、初级、中级、高级',
  `age` varchar(30) DEFAULT NULL COMMENT '适合年龄',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣价',
  `private_discount_price` decimal(10,2) DEFAULT NULL,
  `introduce` varchar(255) DEFAULT NULL COMMENT '简介',
  `tel` char(11) DEFAULT NULL COMMENT '电话',
  `main_img_url` varchar(255) DEFAULT NULL COMMENT '图片地址',
  `stauts` tinyint(3) unsigned DEFAULT '1' COMMENT '状态（1上架2下架）',
  `create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '修改成功',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='空间产品服务';

-- ----------------------------
--  Table structure for `box_course_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `box_course_supplier`;
CREATE TABLE `box_course_supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(10) unsigned NOT NULL COMMENT '空间ID',
  `suppiler_id` int(10) unsigned NOT NULL COMMENT '供应商ID',
  `plan_type` smallint(5) unsigned DEFAULT NULL COMMENT '供应商安排：0听从我方安排1根据空间时间定制计划2固定时间',
  `status` tinyint(4) DEFAULT '2' COMMENT '审核状态1正常2待审核-1审核不通过3禁用',
  `check_info` varchar(255) DEFAULT NULL COMMENT '审核不通过理由',
  `create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT ' 删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='空间服务的供应商服务';

-- ----------------------------
--  Table structure for `box_member_service`
-- ----------------------------
DROP TABLE IF EXISTS `box_member_service`;
CREATE TABLE `box_member_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `service_time_id` int(10) unsigned DEFAULT NULL COMMENT '预约时间ID',
  `yname` varchar(30) DEFAULT NULL COMMENT '预约姓名',
  `ytel` char(11) DEFAULT NULL COMMENT '预约电话',
  `num` int(10) unsigned DEFAULT NULL COMMENT '预约人数',
  `create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '预约状态0未消费1已消费',
  `supplier_id` tinyint(4) DEFAULT '0' COMMENT '0 小程序用户 !0 供应商ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `box_service_time`
-- ----------------------------
DROP TABLE IF EXISTS `box_service_time`;
CREATE TABLE `box_service_time` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` int(11) DEFAULT '0' COMMENT '第三方对接唯一id',
  `sid` int(10) unsigned DEFAULT NULL COMMENT '空间ID',
  `service_id` int(11) NOT NULL COMMENT '空间产品服务ID',
  `start_time` int(10) unsigned NOT NULL COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL COMMENT '结束时间',
  `is_private` tinyint(4) DEFAULT NULL COMMENT '是否私教1：是 2否',
  `initial_stock` int(11) DEFAULT NULL COMMENT '初始库存',
  `stock` int(10) unsigned NOT NULL COMMENT '库存',
  `status` tinyint(3) unsigned DEFAULT '1' COMMENT '状态（1.待约课2已被约3异常）',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `box_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `box_supplier`;
CREATE TABLE `box_supplier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `su_name` varchar(50) NOT NULL DEFAULT '' COMMENT '供应商名称',
  `su_email` varchar(50) NOT NULL DEFAULT '' COMMENT '供应商邮箱',
  `category_id` int(11) DEFAULT NULL COMMENT '分类ID',
  `sid` int(11) DEFAULT NULL,
  `su_logo` varchar(255) DEFAULT '' COMMENT '图标',
  `licence_logo` varchar(255) DEFAULT '' COMMENT '营业执照',
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `description` text NOT NULL COMMENT '描述',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `su_adress` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`su_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商管理';

-- ----------------------------
--  Table structure for `box_trade`
-- ----------------------------
DROP TABLE IF EXISTS `box_trade`;
CREATE TABLE `box_trade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trade_no` char(18) DEFAULT NULL COMMENT '交易号',
  `service_time_id` int(10) unsigned DEFAULT NULL COMMENT '时间ID',
  `supplier_id` int(10) unsigned DEFAULT NULL COMMENT '供应商ID',
  `course_name` varchar(100) DEFAULT NULL COMMENT '课程名称',
  `teacher_name` varchar(100) DEFAULT NULL COMMENT '老师名称',
  `teacher_tel` char(11) DEFAULT NULL COMMENT '老师电话',
  `is_private` tinyint(4) DEFAULT NULL COMMENT '是否私教1：是 2否',
  `start_time` int(11) DEFAULT NULL COMMENT '课程开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '课程结束时间',
  `num` int(11) DEFAULT NULL COMMENT '预约人数',
  `create_time` int(11) DEFAULT NULL COMMENT '下单时间',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态1.未支付2.已支付3.已超时',
  PRIMARY KEY (`id`),
  UNIQUE KEY `trade_no` (`trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `topic_img_id` int(11) DEFAULT NULL COMMENT '外键，关联image表',
  `delete_time` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品类目';

-- ----------------------------
--  Table structure for `chain`
-- ----------------------------
DROP TABLE IF EXISTS `chain`;
CREATE TABLE `chain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ch_name` varchar(50) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1正常 2停用',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `image`
-- ----------------------------
DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_index` (`product_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='图片总表';

-- ----------------------------
--  Records of `image`
-- ----------------------------
BEGIN;
INSERT INTO `image` VALUES ('1', '3', '/product_img/top_balloon1.jpg', '1', null, null), ('2', '3', '/product_img/top_balloon2.jpg', '1', null, null), ('3', '2', '/product_img/top_flower1.jpg', '1', null, null), ('4', '2', '/product_img/top_flower2.jpg', '1', null, null), ('5', '2', '/product_img/top_flower3.jpg', '1', null, null), ('6', '1', '/product_img/top_ticket1.jpg', '1', null, null), ('7', '1', '/product_img/top_ticket2.jpg', '1', null, null), ('8', '1', '/product_img/top_ticket3.jpg', '1', null, null), ('9', '2', '/product_img/top_flower4.jpg', '1', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `admin_id` int(11) DEFAULT NULL,
  `time_id` int(11) DEFAULT NULL,
  `from` tinyint(4) DEFAULT '1' COMMENT '1:本地',
  `user_id` int(11) DEFAULT NULL COMMENT '外键，用户id，注意并不是openid',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `total_price` decimal(6,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.待支付 2.已支付，待使用 3.已使用4已作废',
  `code_img` varchar(255) DEFAULT NULL COMMENT '二维码路径',
  `snap_img` varchar(255) DEFAULT NULL COMMENT '订单快照图片',
  `snap_name` varchar(80) DEFAULT NULL COMMENT '订单快照名称',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) DEFAULT NULL,
  `snap_items` text COMMENT '订单其他信息快照（json)',
  `snap_address` varchar(500) DEFAULT NULL COMMENT '地址快照',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  `feature` varchar(20) DEFAULT NULL,
  `express` varchar(20) DEFAULT NULL,
  `time` varchar(40) DEFAULT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `order`
-- ----------------------------
BEGIN;
INSERT INTO `order` VALUES ('1', 'AC0977322308', null, null, '1', '1', null, '1512820773', '50.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '1', '1512820773', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"50.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":50,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx2017120920002220966828850375199930', 'blacky', '15510996092', null, '1'), ('2', 'AC0911448824', null, null, '1', '3', null, '1512827114', '100.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '2', '1512827114', '[{\"id\":1,\"haveStock\":true,\"counts\":2,\"price\":\"50.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":100,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712092146153b6a5619320350400630', '王', '13500000000', null, '1'), ('3', 'AC0920365349', null, null, '1', '1', null, '1512827203', '50.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '1', '1512827203', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"50.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":50,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712092146445397158c630517839316', 'coco', '13621007725', null, '1'), ('4', 'AC1033636863', null, null, '1', '4', null, '1512888336', '0.01', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '1', '1512888336', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"50.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":50,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712101445363e61253e940463372031', 'blacky', '15510996092', null, '1'), ('5', 'AC1350889573', null, null, '1', '53', null, '1513132508', '40.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '1', '1513132508', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"40.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":40,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712131035091066169da20048702000', '测试', '13800138000', null, '1'), ('6', 'AC1351022766', '1', null, '1', '53', null, '1513132510', '40.00', '3', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '1', '1513132510', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"40.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":40,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx2017121310351087d445ac2c0835623361', '测试', '13800138000', null, '1'), ('7', 'AC1459409911', '1', null, '1', '1', null, '1513232594', '160.00', '3', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '4', '1513232594', '[{\"id\":1,\"haveStock\":true,\"counts\":4,\"price\":\"40.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":160,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712141423146277b9bc610272425095', '123', '13500000000', null, '1'), ('8', 'AC1509502669', '1', null, '1', '56', null, '1513320095', '10.01', '4', '/qrcode/ZETA53f0a9257e3b277cf53023b90ec5022d.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', 'test华熙LIVE，五棵松灯光节', '1', '1513320095', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.01,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712151441354c810e26000371154932', 'JSON', '13554385438', null, '1'), ('9', 'AC1636138030', null, null, '1', null, null, '1513413361', '0.00', '1', '/qrcode/ZETA4daac7a97263c215a7b47c90b2f48547.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('10', 'AC1640805490', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETAe97acb9703b2d6eecd8ab5f97871ad95.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('11', 'AC1640816419', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETAa130ecf03445dc608ab1b485dad17b06.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('12', 'AC1640818750', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETAa697775805342c4ec9ea7d29d92a78ee.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('13', 'AC1640820966', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETA0767de5fc29c5e24ea7adaef12cc18a8.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('14', 'AC1640823266', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETAc9972ec4d18e9eeb2b93fd80c39146ea.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('15', 'AC1640825522', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETA5866f836306e678235c05b121e9ddd91.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('16', 'AC1640827710', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETA709ef0f3b5bad4c0753f5ef39c0dc8a0.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('17', 'AC1640830197', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETA62d6b29462a4be120e14e3a7c550392b.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('18', 'AC1640832467', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETA4c360311235e0ef2115559a120172b10.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('19', 'AC1640834657', null, null, '1', null, null, '1513413408', '0.00', '1', '/qrcode/ZETA40c55b20589fc3f3955610018533336d.png', null, '华熙LIVE，五棵松灯光节（赠票）', '1', null, null, null, null, null, null, null, '1'), ('20', 'AC1793891907', null, null, '1', '56', null, '1513485938', '0.01', '2', '/qrcode/ZETAcf5746353e7290acceab5dc59c3023dd.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '1', '1513485938', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.01,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171217124539ff47a1851d0798369206', 'wertwet', '13500000000', null, '1'), ('21', 'AC1829236728', null, null, '1', '57', null, '1513573292', '0.01', '2', '/qrcode/ZETA882f8638ad441d566ff805744fb1e741.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '1', '1513573292', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.01,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171218130133a611d875d00670995987', '默默哦', '15935168552', null, '1'), ('22', 'AC1808968278', null, null, '1', '62', null, '1513579089', '0.02', '2', '/qrcode/ZETA2bb874ff0f215a902fd89895be20e9d8.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '2', '1513579089', '[{\"id\":1,\"haveStock\":true,\"counts\":2,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.02,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712181438104dfe63f8520035548106', '王友涛', '15116924284', null, '1'), ('23', 'AC1868873225', null, null, '1', '67', null, '1513579688', '0.02', '2', '/qrcode/ZETA96a5ae2ecc75b1da6f8e3d48ebbf211f.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '2', '1513579688', '[{\"id\":1,\"haveStock\":true,\"counts\":2,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.02,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712181448097fd31e02390994553536', '郝梅', '13718470092', null, '1'), ('24', 'AC1805886481', null, null, '1', '70', null, '1513580058', '40.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '1', '1513580058', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.01,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx201712181454190ce3302f6b0166884596', '慕紫', '13654022738', null, '1'), ('25', 'AC1805982621', null, null, '1', '70', null, '1513580059', '40.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '1', '1513580059', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.01,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171218145420515b1360aa0458673829', '慕紫', '13654022738', null, '1'), ('26', 'AC1818820088', null, null, '1', '71', null, '1513580188', '0.02', '2', '/qrcode/ZETA5b130c75756525e50229f4913e160d70.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '2', '1513580188', '[{\"id\":1,\"haveStock\":true,\"counts\":2,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.02,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171218145628895a1724430907261612', '张筱旋', '18810403875', null, '1'), ('27', 'AC1838858787', null, null, '1', '73', null, '1513580388', '0.02', '2', '/qrcode/ZETAadc8d9f7287b97f0203eea3a93c11742.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '限时特惠！华熙LIVE，五棵松灯光节', '2', '1513580388', '[{\"id\":1,\"haveStock\":true,\"counts\":2,\"price\":\"0.01\",\"name\":\"test\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":0.02,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171218145948144d2988ad0006232942', '卢雨舟', '13915977600', null, '1'), ('28', 'AC1826546672', null, null, '1', '72', null, '1513583265', '40.00', '2', '/qrcode/ZETA6446345830a08aefd3906a0f01e3adf0.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '1', '1513583265', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"40.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":40,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx2017121815474521d6e858aa0077602453', '郝少普', '17090096668', null, '1'), ('29', 'AC1830888611', null, null, '1', '91', null, '1513583308', '40.00', '2', '/qrcode/ZETAc93a992565165b691300b9ef7ed7be72.png', 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '1', '1513583308', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"40.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":40,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171218154829148dc1a3630928678879', '谢心', '18811229403', null, '1'), ('30', 'AC1825457050', null, null, '1', '4', null, '1513585254', '40.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '1', '1513585254', '[{\"id\":1,\"haveStock\":true,\"counts\":1,\"price\":\"40.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":40,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171218162111adf8b20f7d0680162578', 'blacky', '15510996092', null, '1'), ('31', 'AC1842659032', null, null, '1', '62', null, '1513591426', '80.00', '1', null, 'https://api.dayaartist.com/product_img/top_ticket1.jpg', '华熙LIVE，五棵松灯光节', '2', '1513591426', '[{\"id\":1,\"haveStock\":true,\"counts\":2,\"price\":\"40.00\",\"name\":\"\\u534e\\u7199LIVE\\uff0c\\u4e94\\u68f5\\u677e\\u706f\\u5149\\u8282\",\"totalPrice\":80,\"main_img_url\":\"https:\\/\\/api.dayaartist.com\\/product_img\\/top_ticket1.jpg\"}]', null, 'wx20171218180347795cff01a30970748141', '王友涛', '15116924284', null, '1');
COMMIT;

-- ----------------------------
--  Table structure for `order_product`
-- ----------------------------
DROP TABLE IF EXISTS `order_product`;
CREATE TABLE `order_product` (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` int(11) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `create_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `feature` varchar(20) DEFAULT NULL,
  `express` varchar(20) DEFAULT NULL,
  `time` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `order_product`
-- ----------------------------
BEGIN;
INSERT INTO `order_product` VALUES ('1', '1', '1', '1512820773', null, '1512820773', null, null, null), ('2', '1', '2', '1512827114', null, '1512827114', null, null, null), ('3', '1', '1', '1512827203', null, '1512827203', null, null, null), ('4', '1', '1', '1512888336', null, '1512888336', null, null, null), ('5', '1', '1', '1513132508', null, '1513132508', null, null, null), ('6', '1', '1', '1513132510', null, '1513132510', null, null, null), ('7', '1', '4', '1513232594', null, '1513232594', null, null, null), ('8', '1', '1', '1513320095', null, '1513320095', null, null, null), ('20', '1', '1', '1513485938', null, '1513485938', null, null, null), ('21', '1', '1', '1513573292', null, '1513573292', null, null, null), ('22', '1', '2', '1513579089', null, '1513579089', null, null, null), ('23', '1', '2', '1513579688', null, '1513579688', null, null, null), ('24', '1', '1', '1513580058', null, '1513580058', null, null, null), ('25', '1', '1', '1513580059', null, '1513580059', null, null, null), ('26', '1', '2', '1513580188', null, '1513580188', null, null, null), ('27', '1', '2', '1513580388', null, '1513580388', null, null, null), ('28', '1', '1', '1513583265', null, '1513583265', null, null, null), ('29', '1', '1', '1513583308', null, '1513583308', null, null, null), ('30', '1', '1', '1513585254', null, '1513585254', null, null, null), ('31', '1', '2', '1513591426', null, '1513591426', null, null, null);
COMMIT;

-- ----------------------------
--  Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '商品名称',
  `describe` varchar(80) DEFAULT NULL COMMENT '商品描述',
  `main_img_url` varchar(255) DEFAULT NULL,
  `content` text,
  `duration` varchar(80) DEFAULT NULL COMMENT '时间段',
  `address` varchar(80) DEFAULT NULL COMMENT '商品描述',
  `price` decimal(6,2) DEFAULT NULL COMMENT '价格,单位：分',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `is_pre` int(11) NOT NULL COMMENT '是否预售',
  `delete_time` int(11) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '图片来自 1 本地 ，2公网',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `product`
-- ----------------------------
BEGIN;
INSERT INTO `product` VALUES ('1', '华熙LIVE，五棵松灯光节', '2017冬天国内最高质量最国际化的灯光节', '/product_img/top_ticket1.jpg', '&lt;p style=&quot;white-space: normal;&quot;&gt;这里的炫酷堪比京城最火爆的夜店，但又没有刺鼻的烟味儿；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;这里的闪耀堪比世贸天阶抬头巨大的荧屏，但又多变好玩场景丰富；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;这里的科幻堪比好莱坞大作特效，但又可互动可操控趣味横生。&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802302430860.jpg&quot; title=&quot;1512802302430860.jpg&quot; alt=&quot;content_img1.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;每一款灯光的照射下，展现你的魅力；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;每一次场景的变幻下，发现你的侧脸如此迷人；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;每一条光线中，留下都市生活的身影……&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802322346689.jpg&quot; title=&quot;1512802322346689.jpg&quot; alt=&quot;content_img2.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;整场秀引进大量国内外艺术家的灯光艺术装置，打造一场光与影的盛宴，强调人与灯光的互动，突出艺术与互动技术的结合，看到光，感受光，控制光的魔法。&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802352152639.jpg&quot; title=&quot;1512802352152639.jpg&quot; alt=&quot;content_img3.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802407300082.jpg&quot; title=&quot;1512802407300082.jpg&quot; alt=&quot;1.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802419578126.jpg&quot; title=&quot;1512802419578126.jpg&quot; alt=&quot;3.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802610897732.jpg&quot; title=&quot;1512802610897732.jpg&quot; alt=&quot;相框.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;Lights Photo&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;Let’s Photo&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;华熙国际灯光节，将成为继伦敦，悉尼灯光节后世界知名的艺术灯光节！&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;12月24日至3月4日，五棵松等你来。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '2017.12.24-2018.03.04  17:00--22:00', '北京市海淀区复兴路69号', '40.00', '98', '1', null, null, '1', null, null, '1'), ('2', '彩色发光花(现场优惠发售)', '2017冬天国内最高质量最国际化的灯光节', '/product_img/1.pic_hd.jpg', '&lt;p style=&quot;white-space: normal;&quot;&gt;这里的炫酷堪比京城最火爆的夜店，但又没有刺鼻的烟味儿；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;这里的闪耀堪比世贸天阶抬头巨大的荧屏，但又多变好玩场景丰富；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;这里的科幻堪比好莱坞大作特效，但又可互动可操控趣味横生。&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802074425471.jpg&quot; title=&quot;1512802074425471.jpg&quot; alt=&quot;content_img1.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802084660168.jpg&quot; title=&quot;1512802084660168.jpg&quot; alt=&quot;content_img2.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802089354954.jpg&quot; title=&quot;1512802089354954.jpg&quot; alt=&quot;content_img3.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802097288538.jpg&quot; title=&quot;1512802097288538.jpg&quot; alt=&quot;content_img4.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802102725389.jpg&quot; title=&quot;1512802102725389.jpg&quot; alt=&quot;content_img5.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802106800575.jpg&quot; title=&quot;1512802106800575.jpg&quot; alt=&quot;content_img6.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '2017.12.24-2018.03.04  17:00--22:00', '北京市海淀区复兴路69号', '39.00', '100', '1', null, null, '1', null, null, '1'), ('3', '发光波波球(现场优惠发售)', '2017冬天国内最高质量最国际化的灯光节', '/product_img/2.pic_hd.jpg', '&lt;p style=&quot;white-space: normal;&quot;&gt;这里的炫酷堪比京城最火爆的夜店，但又没有刺鼻的烟味儿；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;这里的闪耀堪比世贸天阶抬头巨大的荧屏，但又多变好玩场景丰富；&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;这里的科幻堪比好莱坞大作特效，但又可互动可操控趣味横生。&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802191626083.jpg&quot; title=&quot;1512802191626083.jpg&quot; alt=&quot;content_img1.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802197807798.jpg&quot; title=&quot;1512802197807798.jpg&quot; alt=&quot;content_img2.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802203961690.jpg&quot; title=&quot;1512802203961690.jpg&quot; alt=&quot;content_img3.jpg&quot;/&gt;&lt;img src=&quot;http://cs.cms.joyfamliy.com:2017/ueditor/php/upload/image/20171209/1512802208938590.jpg&quot; title=&quot;1512802208938590.jpg&quot; alt=&quot;content_img4.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '2017.12.24-2018.03.04  17:00--22:00', '北京市海淀区复兴路69号', '65.00', '100', '1', null, null, '1', null, null, '1');
COMMIT;

-- ----------------------------
--  Table structure for `product_describe`
-- ----------------------------
DROP TABLE IF EXISTS `product_describe`;
CREATE TABLE `product_describe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) DEFAULT NULL COMMENT '外键，关联图片表',
  `content` varchar(255) DEFAULT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '图片排序序号',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `product_feature`
-- ----------------------------
DROP TABLE IF EXISTS `product_feature`;
CREATE TABLE `product_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature` varchar(255) DEFAULT '' COMMENT '详情属性名称',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `product_image`
-- ----------------------------
DROP TABLE IF EXISTS `product_image`;
CREATE TABLE `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `product_property`
-- ----------------------------
DROP TABLE IF EXISTS `product_property`;
CREATE TABLE `product_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) DEFAULT NULL COMMENT '商品id，外键',
  `course_plan_id` int(10) unsigned DEFAULT NULL COMMENT '课程ID',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `product_size`
-- ----------------------------
DROP TABLE IF EXISTS `product_size`;
CREATE TABLE `product_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(255) DEFAULT '' COMMENT '详情属性名称',
  `price` decimal(6,0) DEFAULT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `product_tag`
-- ----------------------------
DROP TABLE IF EXISTS `product_tag`;
CREATE TABLE `product_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `product_time`
-- ----------------------------
DROP TABLE IF EXISTS `product_time`;
CREATE TABLE `product_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` varchar(255) DEFAULT '' COMMENT '详情属性名称',
  `end_time` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `rbac_auth`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_auth`;
CREATE TABLE `rbac_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_name` varchar(30) DEFAULT NULL COMMENT '权限名称',
  `auth_pid` int(11) DEFAULT NULL COMMENT '父级ID',
  `auth_c` varchar(30) DEFAULT NULL COMMENT '控制器',
  `auth_a` varchar(30) DEFAULT NULL COMMENT '方法',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `rbac_role`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_role`;
CREATE TABLE `rbac_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) DEFAULT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `rbac_role_auth`
-- ----------------------------
DROP TABLE IF EXISTS `rbac_role_auth`;
CREATE TABLE `rbac_role_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL COMMENT '角色ID',
  `auth_id` int(11) DEFAULT NULL COMMENT '权限ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `security`
-- ----------------------------
DROP TABLE IF EXISTS `security`;
CREATE TABLE `security` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `appid` char(10) DEFAULT NULL,
  `secret` char(20) DEFAULT NULL,
  `appkey` char(30) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `appid` (`appid`),
  UNIQUE KEY `secret` (`secret`) USING BTREE,
  UNIQUE KEY `appkey` (`appkey`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `theme`
-- ----------------------------
DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '专题名称',
  `description` varchar(255) DEFAULT NULL COMMENT '专题描述',
  `shop_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `video_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `date_img_id` int(11) NOT NULL COMMENT '主题图，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `del` tinyint(4) DEFAULT '1' COMMENT '1.启用；2.禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题信息表';

-- ----------------------------
--  Table structure for `theme_product`
-- ----------------------------
DROP TABLE IF EXISTS `theme_product`;
CREATE TABLE `theme_product` (
  `theme_id` int(11) NOT NULL COMMENT '主题外键',
  `product_id` int(11) NOT NULL COMMENT '商品外键',
  PRIMARY KEY (`theme_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题所包含的商品';

-- ----------------------------
--  Table structure for `third_app`
-- ----------------------------
DROP TABLE IF EXISTS `third_app`;
CREATE TABLE `third_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) NOT NULL COMMENT '应用app_id',
  `app_secret` varchar(64) NOT NULL COMMENT '应用secret',
  `app_description` varchar(100) DEFAULT NULL COMMENT '应用程序描述',
  `scope` varchar(20) NOT NULL COMMENT '应用权限',
  `scope_description` varchar(100) DEFAULT NULL COMMENT '权限描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问API的各应用账号密码表';

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `nickName` varchar(50) DEFAULT NULL COMMENT '昵称',
  `gender` tinyint(4) DEFAULT NULL COMMENT '性别：2女性1男性',
  `avatarUrl` varchar(255) DEFAULT NULL COMMENT '头像',
  `city` varchar(30) DEFAULT NULL COMMENT '城市',
  `province` varchar(20) DEFAULT NULL COMMENT '省份',
  `country` varchar(30) DEFAULT NULL COMMENT '国家',
  `language` varchar(30) DEFAULT NULL COMMENT '语言',
  `extend` varchar(255) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型（1普通用户2预约用户3普通+预约）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'ohzwU0TDzhzkGdX_xEFLuV0LSW10', 'coco', '0', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqgqwibl6cHtTdYuDAWaWWuoHaeQpwNCTFX1TcbGLJHGSic1I0e1iaibhUDFZMAg9AQug4t1x5tibNTpwg/0', '', '', '', 'en', null, null, '1512827103', '1512827103', '1', '1'), ('2', 'ohzwU0ac_Txfkwqw3ZHeKMKIcl78', null, null, null, null, null, null, null, null, null, '1512827185', '1512827185', '1', '1'), ('3', 'ohzwU0R1U4CSkJ5vLQNNY0l5eS7U', '尛`乖怪 ο◎', '2', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK1t4MFc7AUOBoKLtgn45kGN4pg6CGHpEHCoQuNG6muPOdkaibvicZz3RBK1bxDmG4lQibYO7V2flLGA/0', 'Fengtai', 'Beijing', 'China', 'zh_CN', null, null, '1512827318', '1512827318', '1', '1'), ('4', 'ohzwU0Q2ZjRJ1VRzFYDDynWmtrBo', 'Blacky', '1', 'https://wx.qlogo.cn/mmopen/vi_32/CeddN8YYNdPmDcJ0EqF2L10QbaAL5JPNrg1o061En9mo7oe8xKuxszXF2hoqW8YZWiaCkBiaticL2pw9tJ8W223Jw/0', '', '', 'Bermuda', 'en', null, null, '1512827574', '1512827574', '1', '1'), ('5', 'ohzwU0dqUkzVT4ticL58OTtKCUhg', 'rdgztest_GLNOCT', '0', '', '', '', '', 'zh_CN', null, null, '1512828153', '1512828153', '1', '1'), ('6', 'ohzwU0bj-7heRuChD_pyWPrDCvu0', null, null, null, null, null, null, null, null, null, '1512833721', '1512833721', '1', '1'), ('7', 'ohzwU0Uae38CuZBHr62S9NSQPGJM', '尛`乖怪 ο◎', '2', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK1t4MFc7AUOBoKLtgn45kGN4pg6CGHpEHCoQuNG6muPOdkaibvicZz3RBK1bxDmG4lQibYO7V2flLGA/0', 'Fengtai', 'Beijing', 'China', 'zh_CN', null, null, '1512834674', '1512834674', '1', '1'), ('8', 'ohzwU0TSP9YJl1U8ffLIPDb4vzBE', null, null, null, null, null, null, null, null, null, '1512835245', '1512835245', '1', '1'), ('9', 'ohzwU0UF5fwB0eXI9VXIuINKgEKQ', null, null, null, null, null, null, null, null, null, '1512836169', '1512836169', '1', '1'), ('10', 'ohzwU0c3HnyozX5WyBIZYePAz3N4', null, null, null, null, null, null, null, null, null, '1512836554', '1512836554', '1', '1'), ('11', 'ohzwU0eVrjF6a3Je38V7xIHshuV8', null, null, null, null, null, null, null, null, null, '1512862670', '1512862670', '1', '1'), ('12', 'ohzwU0Rl7C8a_Y7yTIVsH7xZtL1Q', null, null, null, null, null, null, null, null, null, '1512865814', '1512865814', '1', '1'), ('13', 'ohzwU0ewd8B02p4ANauocIJKktuk', null, null, null, null, null, null, null, null, null, '1512868993', '1512868993', '1', '1'), ('14', 'ohzwU0REaCOpMnJyz49qTIifurnw', null, null, null, null, null, null, null, null, null, '1512870834', '1512870834', '1', '1'), ('15', 'ohzwU0bR-RLWXcjX3U6R4kHkfrjU', null, null, null, null, null, null, null, null, null, '1512896465', '1512896465', '1', '1'), ('16', 'ohzwU0bsP5mCVx9dC6DwCGbgY_1U', null, null, null, null, null, null, null, null, null, '1512896549', '1512896549', '1', '1'), ('17', 'ohzwU0Y6thxcEshDotHF5W9bQCVA', null, null, null, null, null, null, null, null, null, '1512896595', '1512896595', '1', '1'), ('18', 'ohzwU0fF8NyzqX8FeN95PMKcwbtA', null, null, null, null, null, null, null, null, null, '1512897261', '1512897261', '1', '1'), ('19', 'ohzwU0c2miA0KoIM9-IxzSgcStJE', null, null, null, null, null, null, null, null, null, '1512897419', '1512897419', '1', '1'), ('20', 'ohzwU0SSh1zfOD1xzw-amk8QlbvU', null, null, null, null, null, null, null, null, null, '1512897510', '1512897510', '1', '1'), ('21', 'ohzwU0Rf8xaSrrV5HewdWgCACo9U', null, null, null, null, null, null, null, null, null, '1512897851', '1512897851', '1', '1'), ('22', 'ohzwU0Y5bT5WgEB9ZIYiqqkC_RdU', null, null, null, null, null, null, null, null, null, '1512898023', '1512898023', '1', '1'), ('23', 'ohzwU0aC8Exq9AoEVCyoH6jrTePQ', null, null, null, null, null, null, null, null, null, '1512898271', '1512898271', '1', '1'), ('24', 'ohzwU0V-VMgbWYTxQDWxNe1yFAaU', null, null, null, null, null, null, null, null, null, '1512898388', '1512898388', '1', '1'), ('25', 'ohzwU0bEH_Yo5_acyVXmghtcIJPU', null, null, null, null, null, null, null, null, null, '1512899037', '1512899037', '1', '1'), ('26', 'ohzwU0fwM23VExWeS1G_n4Bty4Ts', null, null, null, null, null, null, null, null, null, '1512899284', '1512899284', '1', '1'), ('27', 'ohzwU0XS8AKL_46pfXFp39TYfNvI', null, null, null, null, null, null, null, null, null, '1512899402', '1512899402', '1', '1'), ('28', 'ohzwU0Xrj5VmCyqTcoOW46L0q6PA', null, null, null, null, null, null, null, null, null, '1512899523', '1512899523', '1', '1'), ('29', 'ohzwU0X4YXi0VXur9phVRi9AM7nY', null, null, null, null, null, null, null, null, null, '1512899556', '1512899556', '1', '1'), ('30', 'ohzwU0eqf3W9yj8QXZ9bZdpxMcmo', null, null, null, null, null, null, null, null, null, '1512899692', '1512899692', '1', '1'), ('31', 'ohzwU0ecF7-R9qI2eAVc-sTsYiqM', null, null, null, null, null, null, null, null, null, '1512900298', '1512900298', '1', '1'), ('32', 'ohzwU0aBv8b5_tlZXghmSnKuP1qE', null, null, null, null, null, null, null, null, null, '1512900639', '1512900639', '1', '1'), ('33', 'ohzwU0Rk-66bfrn70XbbHY-7Jmbk', null, null, null, null, null, null, null, null, null, '1512900732', '1512900732', '1', '1'), ('34', 'ohzwU0dsmV5GfzLHMV-kUCdNrWug', null, null, null, null, null, null, null, null, null, '1512900815', '1512900815', '1', '1'), ('35', 'ohzwU0dZUf3Hd66-ei9NwLsMjIvM', null, null, null, null, null, null, null, null, null, '1512901205', '1512901205', '1', '1'), ('36', 'ohzwU0YmmuG1aNT4DOroTdiFgnNM', null, null, null, null, null, null, null, null, null, '1512902120', '1512902120', '1', '1'), ('37', 'ohzwU0auTvV1aietpEfYDpCZVEOk', null, null, null, null, null, null, null, null, null, '1512904808', '1512904808', '1', '1'), ('38', 'ohzwU0esZcVIj8yV277UYIy2ooPA', null, null, null, null, null, null, null, null, null, '1512909441', '1512909441', '1', '1'), ('39', 'ohzwU0UrdB5-ujRUE3f3MwhxTaM4', null, null, null, null, null, null, null, null, null, '1512911681', '1512911681', '1', '1'), ('40', 'ohzwU0QNI9h0tsAwIGUrR3avheFQ', null, null, null, null, null, null, null, null, null, '1512914481', '1512914481', '1', '1'), ('41', 'ohzwU0W3Cx0So8rRKLhByLbX4-Lc', null, null, null, null, null, null, null, null, null, '1512914538', '1512914538', '1', '1'), ('42', 'ohzwU0cBd7WaIQXbrcHUlT2yr7EI', null, null, null, null, null, null, null, null, null, '1512914708', '1512914708', '1', '1'), ('43', 'ohzwU0TYvdJUrG83akdA7d-PZ580', null, null, null, null, null, null, null, null, null, '1512915536', '1512915536', '1', '1'), ('44', 'ohzwU0UxOcIS6kMo272VJbo1M3f4', null, null, null, null, null, null, null, null, null, '1512918610', '1512918610', '1', '1'), ('45', 'ohzwU0VOmaMgywWB7xA2rDH_aq_c', null, null, null, null, null, null, null, null, null, '1512918677', '1512918677', '1', '1'), ('46', 'ohzwU0bVOb9haNrG7sergJrvLfqk', null, null, null, null, null, null, null, null, null, '1512919085', '1512919085', '1', '1'), ('47', 'ohzwU0ZiWcPqfuu9Neu3y7akU9vI', null, null, null, null, null, null, null, null, null, '1512980700', '1512980700', '1', '1'), ('48', 'ohzwU0ZzFTsVyJ4QQHyYFZAYDUs0', null, null, null, null, null, null, null, null, null, '1512986252', '1512986252', '1', '1'), ('49', 'ohzwU0euILt-2pEznsPe4guCbOM0', null, null, null, null, null, null, null, null, null, '1512999747', '1512999747', '1', '1'), ('50', 'ohzwU0ar0AtAKLfrM8Ze8_64oEyU', null, null, null, null, null, null, null, null, null, '1513003619', '1513003619', '1', '1'), ('51', 'ohzwU0eC28HFi6yLwFJVANE-8WqI', '叁金i', '2', 'https://wx.qlogo.cn/mmopen/vi_32/aHYicMW89y6T5nBk47vJhuWSicoictBSqODZ9KyBpwHwicuEXrzFVibnSicSgficQ4ymdicLYop3TZ2dqvt2xM5YUcuYCg/0', 'Chaoyang', 'Beijing', 'China', 'zh_CN', null, null, '1513035908', '1513035908', '1', '1'), ('52', 'ohzwU0fVsDPQE2Yj-g5DuBKykA-M', null, null, null, null, null, null, null, null, null, '1513132058', '1513132058', '1', '1'), ('53', 'ohzwU0eeaCIbkFlPVrpCHmxs0984', 'Alexander Nie', '1', 'https://wx.qlogo.cn/mmopen/vi_32/ajNVdqHZLLCrSgd5kN5VPDkP0858feTmjhhtPkj2tyunrIHgV6ia755WF9AMrOThGhKtGrsgybKeQHTJdFY2n9A/0', 'Chaoyang', 'Beijing', 'China', 'zh_CN', null, null, '1513132482', '1513132482', '1', '1'), ('54', 'ohzwU0Z_PtypDVtymIKH8MbaBll4', null, null, null, null, null, null, null, null, null, '1513135135', '1513135135', '1', '1'), ('55', 'ohzwU0YjTeziIjbH5ueup44CEi9g', null, null, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK1t4MFc7AUOBoKLtgn45kGN4pg6CGHpEHCoQuNG6muPOdkaibvicZz3RBK1bxDmG4lQibYO7V2flLGA/0', null, null, null, null, null, null, '1513148298', '1513148298', '1', '1'), ('56', 'ohzwU0UjuRuHmZJ94i_hoWSb2tOs', '阿布', '1', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLz98wibyJ4nIWHDwJbfR2iaAQIPlCAia1QXlPkgqOicfrCLQZ1rH8sNbQdXlN0vP8nZKMqB4bERA0SIw/0', 'Liaocheng', 'Shandong', 'China', 'zh_CN', null, null, '1513246799', '1513246799', '1', '1'), ('57', 'ohzwU0VL7c-Y9togK52IWj0tpYo4', '　', '1', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLo5MhlEPZcnxL4y3IOV5pNicmciahZ3TbQ1D9Wz03LUohkpTYPOvxLj1Ykicibiak8U0jxvCo4n5jfV2Q/0', '', 'Male', 'Maldives', 'zh_CN', null, null, '1513406771', '1513406771', '1', '1'), ('58', 'ohzwU0dQ0PNMhv2OdDL1V9fP6pZ4', null, null, null, null, null, null, null, null, null, '1513494117', '1513494117', '1', '1'), ('59', 'ohzwU0V59nfPTZrsBr6NfZcVELSQ', null, null, null, null, null, null, null, null, null, '1513500938', '1513500938', '1', '1'), ('60', 'ohzwU0b-AggB-hOxsorTZo32VhGU', null, null, null, null, null, null, null, null, null, '1513506025', '1513506025', '1', '1'), ('61', 'ohzwU0XiU-TaKNixi04Kf2I5jFw0', null, null, null, null, null, null, null, null, null, '1513511351', '1513511351', '1', '1'), ('62', 'ohzwU0TqMlYJdb5vVD8ZIF6E5qAc', 'Timo', '1', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83epm2iaYJt0ZkwBqbMLcPCXAyiaM7oXVj4oibBqwcFhobT7lfKWlxWtmCurjLz3vibyP3EicYOjic02nSmFA/0', 'Chaoyang', 'Beijing', 'China', 'zh_CN', null, null, '1513579050', '1513579050', '1', '1'), ('63', 'ohzwU0eHHMvGJm9LMGc4pq78g0_U', null, null, null, null, null, null, null, null, null, '1513579090', '1513579090', '1', '1'), ('64', 'ohzwU0a1YNTAgIZkdzdAvsv60FnI', null, null, null, null, null, null, null, null, null, '1513579154', '1513579154', '1', '1'), ('65', 'ohzwU0fZ2JL54YCpLMMsbeePYdOA', null, null, null, null, null, null, null, null, null, '1513579168', '1513579168', '1', '1'), ('66', 'ohzwU0QVdM9plXb3frUtJGUr2fQE', null, null, null, null, null, null, null, null, null, '1513579225', '1513579225', '1', '1'), ('67', 'ohzwU0ZcZa6y33GV_Zu7-tXenxAo', 'Kiros', '2', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKQWVO4ebJ6IRmSQ5sy4kGOaYTLenHQpLM3gzyPia3Lkfvvp8krAYicJql2jd9J31FkWxTkADRicxcHw/0', 'East', 'Beijing', 'China', 'zh_CN', null, null, '1513579254', '1513579254', '1', '1'), ('68', 'ohzwU0fj3u9c-YYCOauqPD996T_I', null, null, null, null, null, null, null, null, null, '1513579374', '1513579374', '1', '1'), ('69', 'ohzwU0Q0zmpmBmglcF-170qWz9aY', null, null, null, null, null, null, null, null, null, '1513579380', '1513579380', '1', '1'), ('70', 'ohzwU0QftxO90JTWSUhHPD2U89Vs', '慕紫（李英昊）', '2', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJicIU2RQv1V0NXrENSyXEL0NGia8m9TxqAicmXAOuTxQdYSY4FH8ib2g25xX1Z4HR1SBHyiabtoT4hI0g/0', 'Haidian', 'Beijing', 'China', 'zh_CN', null, null, '1513580007', '1513580007', '1', '1'), ('71', 'ohzwU0TAnVofozK1_faDhp15nvXA', '雨生花开时。', '2', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLM6D491yicFPPy6nhd6OZBN8En9ZnaLuvfxSErkxIdHzyV2Z78yUkRnfFf8ibIjVlicetScfLeUeictQ/0', '', '', 'China', 'en', null, null, '1513580141', '1513580141', '1', '1'), ('72', 'ohzwU0bk8h8VZyPsXZkVtkPfKVsI', '郝开心', '1', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eo8DTCPIDnSpsOUr6dT5MeORJppS0ozaIG9PpCaU6XvEYjDgHOMEMibknibOT7LAJP4cBpHVhicib8nsg/0', 'Haidian', 'Beijing', 'China', 'zh_CN', null, null, '1513580283', '1513580283', '1', '1'), ('73', 'ohzwU0Wt0piLGO0cpaTPMV0rseWE', 'Little Lu', '2', 'https://wx.qlogo.cn/mmopen/vi_32/7icUFoSROxdDph87qADTSI0I4u7FvLfrv2iaicjUfg6OA44vtoFqrt8icZVh0cozKMFnpU6O8bJzibQGJdA4iaeRnwibg/0', '', '', 'United States', 'en', null, null, '1513580295', '1513580295', '1', '1'), ('74', 'ohzwU0dDOTdrAxMS9FNWp11c6HZQ', null, null, null, null, null, null, null, null, null, '1513580321', '1513580321', '1', '1'), ('75', 'ohzwU0UhNmjDMDKhN0bHDekW75J4', null, null, null, null, null, null, null, null, null, '1513580578', '1513580578', '1', '1'), ('76', 'ohzwU0UMQsoxKfXciiTqdXz-No-g', null, null, null, null, null, null, null, null, null, '1513580653', '1513580653', '1', '1'), ('77', 'ohzwU0UUhnUxHhl1UHaIWG2yrsD0', null, null, null, null, null, null, null, null, null, '1513580700', '1513580700', '1', '1'), ('78', 'ohzwU0U6a-OjCDyO-NMhcMRbW7D0', null, null, null, null, null, null, null, null, null, '1513580754', '1513580754', '1', '1'), ('79', 'ohzwU0U0OkHn2Tkodpb1QHC7LCNo', null, null, null, null, null, null, null, null, null, '1513580965', '1513580965', '1', '1'), ('80', 'ohzwU0e1qY1kRXMFD8x4yXz0e4Rc', null, null, null, null, null, null, null, null, null, '1513581108', '1513581108', '1', '1'), ('81', 'ohzwU0Xs2qNXSkuX6pibfrrytH0M', null, null, null, null, null, null, null, null, null, '1513581260', '1513581260', '1', '1'), ('82', 'ohzwU0dtgyhBy_KnY0yBDuxWLzGE', null, null, null, null, null, null, null, null, null, '1513581265', '1513581265', '1', '1'), ('83', 'ohzwU0e_qNjJ-rYGEXr9VznxSvnM', null, null, null, null, null, null, null, null, null, '1513581644', '1513581644', '1', '1'), ('84', 'ohzwU0UIzueZCWi7tsPdOeWIsopo', null, null, null, null, null, null, null, null, null, '1513581836', '1513581836', '1', '1'), ('85', 'ohzwU0erN5JIibN0iy6VD5JoF_zA', null, null, null, null, null, null, null, null, null, '1513581844', '1513581844', '1', '1'), ('86', 'ohzwU0Wd92ZT34M7bz2W5-5JKoKU', null, null, null, null, null, null, null, null, null, '1513581877', '1513581877', '1', '1'), ('87', 'ohzwU0VEiGMlU5vStUEic95D2QBs', null, null, null, null, null, null, null, null, null, '1513581896', '1513581896', '1', '1'), ('88', 'ohzwU0Za5Oi8wpvV9La3BFxCjaVo', null, null, null, null, null, null, null, null, null, '1513582012', '1513582012', '1', '1'), ('89', 'ohzwU0QjmIrxArUjeh3vjuAlYAkA', null, null, null, null, null, null, null, null, null, '1513582015', '1513582015', '1', '1'), ('90', 'ohzwU0d7n_-eNVFQeY50PmdebNqQ', null, null, null, null, null, null, null, null, null, '1513582602', '1513582602', '1', '1'), ('91', 'ohzwU0cYpqkWdq73YQpT4080OHno', null, null, null, null, null, null, null, null, null, '1513582728', '1513582728', '1', '1'), ('92', 'ohzwU0RsOPvoRJIr5-Pci7RKm3Pc', null, null, null, null, null, null, null, null, null, '1513582759', '1513582759', '1', '1'), ('93', 'ohzwU0XCi6QFLVdHmP0OH9MnLlrs', null, null, null, null, null, null, null, null, null, '1513582835', '1513582835', '1', '1'), ('94', 'ohzwU0aMiLOENoT6d2pCZW9JGdHE', null, null, null, null, null, null, null, null, null, '1513582841', '1513582841', '1', '1'), ('95', 'ohzwU0VyfzZAw027rpgq5OL_CMrI', null, null, null, null, null, null, null, null, null, '1513582904', '1513582904', '1', '1'), ('96', 'ohzwU0Z2ECdW10lpaQmTjhnE-CpA', null, null, null, null, null, null, null, null, null, '1513582989', '1513582989', '1', '1'), ('97', 'ohzwU0fa1VzIbvMxThs8qfDmd-d4', null, null, null, null, null, null, null, null, null, '1513583093', '1513583093', '1', '1'), ('98', 'ohzwU0TbEp1cdJDzXX_9qcesz2l4', null, null, null, null, null, null, null, null, null, '1513583177', '1513583177', '1', '1'), ('99', 'ohzwU0TrpaIi1to8D0G2dvaah_Io', null, null, null, null, null, null, null, null, null, '1513583227', '1513583227', '1', '1'), ('100', 'ohzwU0cTQEqItmQKu96ixeeARECE', null, null, null, null, null, null, null, null, null, '1513583511', '1513583511', '1', '1'), ('101', 'ohzwU0R_WZ-rMzc4kKbI6-HEDamM', null, null, null, null, null, null, null, null, null, '1513583657', '1513583657', '1', '1'), ('102', 'ohzwU0TU9dI1feXyAZnk6jNU-lv4', null, null, null, null, null, null, null, null, null, '1513583792', '1513583792', '1', '1'), ('103', 'ohzwU0Ycx3r4YlJJoZ24qzHiRAPw', null, null, null, null, null, null, null, null, null, '1513583842', '1513583842', '1', '1'), ('104', 'ohzwU0dk6qnyQ3oreZrQoJTHbzpA', null, null, null, null, null, null, null, null, null, '1513584304', '1513584304', '1', '1'), ('105', 'ohzwU0bKs7CSfVxceF7U2h6aoA8o', null, null, null, null, null, null, null, null, null, '1513584592', '1513584592', '1', '1'), ('106', 'ohzwU0VoFMFd89I7S3jy7K8XS8ds', null, null, null, null, null, null, null, null, null, '1513585363', '1513585363', '1', '1'), ('107', 'ohzwU0TMAYpZJ-TsYVXtLppEaZBI', null, null, null, null, null, null, null, null, null, '1513585504', '1513585504', '1', '1'), ('108', 'ohzwU0b3VrqI6rnerx6fdC9eEJmo', null, null, null, null, null, null, null, null, null, '1513589237', '1513589237', '1', '1');
COMMIT;

-- ----------------------------
--  Table structure for `user_address`
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `country` varchar(20) DEFAULT NULL COMMENT '区',
  `detail` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `video`
-- ----------------------------
DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '商品名称',
  `describe` varchar(80) DEFAULT NULL COMMENT '商品描述',
  `content` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `duration` varchar(80) DEFAULT NULL COMMENT '商品描述',
  `delete_time` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `main_img_url` varchar(255) DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `main_video_url` varchar(255) DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '图片来自 1 本地 ，2公网',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL,
  `summary` varchar(50) DEFAULT NULL COMMENT '摘要',
  `img_id` int(11) DEFAULT NULL COMMENT '图片外键',
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

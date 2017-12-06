-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2017-12-06 15:46:58
-- 服务器版本： 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artists`
--

-- --------------------------------------------------------

--
-- 表的结构 `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
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
  `latitude` decimal(14,8) NOT NULL DEFAULT '0.00000000' COMMENT '纬度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `adminuser`
--

CREATE TABLE `adminuser` (
  `id` int(11) NOT NULL COMMENT '用户表：包括后台管理员、商家会员和普通会员',
  `name` varchar(20) NOT NULL COMMENT '登陆账号',
  `uname` varchar(10) DEFAULT NULL COMMENT '昵称',
  `pwd` varchar(50) NOT NULL COMMENT 'MD5密码',
  `qx` tinyint(4) NOT NULL DEFAULT '5' COMMENT '权限 4超级管理员 5普通管理员2供应商',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  `del` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `supplier_id` int(11) DEFAULT NULL COMMENT '供应商ID',
  `role_id` int(11) DEFAULT NULL COMMENT '角色ID'
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) DEFAULT NULL COMMENT 'Banner描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner管理表';

-- --------------------------------------------------------

--
-- 表的结构 `banner_item`
--

CREATE TABLE `banner_item` (
  `id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题',
  `delete_time` int(11) DEFAULT NULL,
  `banner_id` int(11) NOT NULL COMMENT '外键，关联banner表',
  `update_time` int(11) DEFAULT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='banner子项表';

-- --------------------------------------------------------

--
-- 表的结构 `box_course`
--

CREATE TABLE `box_course` (
  `sid` int(11) NOT NULL,
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
  `check_info` tinyint(4) NOT NULL DEFAULT '0' COMMENT '审核不通过理由 '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='空间服务';

-- --------------------------------------------------------

--
-- 表的结构 `box_course_plan`
--

CREATE TABLE `box_course_plan` (
  `id` int(11) NOT NULL,
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
  `from` tinyint(4) DEFAULT '1' COMMENT '类型1本地2第三方'
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='空间产品服务计划';

-- --------------------------------------------------------

--
-- 表的结构 `box_course_service`
--

CREATE TABLE `box_course_service` (
  `id` int(10) unsigned NOT NULL,
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
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='空间产品服务';

-- --------------------------------------------------------

--
-- 表的结构 `box_course_supplier`
--

CREATE TABLE `box_course_supplier` (
  `id` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL COMMENT '空间ID',
  `suppiler_id` int(10) unsigned NOT NULL COMMENT '供应商ID',
  `plan_type` smallint(5) unsigned DEFAULT NULL COMMENT '供应商安排：0听从我方安排1根据空间时间定制计划2固定时间',
  `status` tinyint(4) DEFAULT '2' COMMENT '审核状态1正常2待审核-1审核不通过3禁用',
  `check_info` varchar(255) DEFAULT NULL COMMENT '审核不通过理由',
  `create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT ' 删除时间'
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='空间服务的供应商服务';

-- --------------------------------------------------------

--
-- 表的结构 `box_member_service`
--

CREATE TABLE `box_member_service` (
  `id` int(10) unsigned NOT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `service_time_id` int(10) unsigned DEFAULT NULL COMMENT '预约时间ID',
  `yname` varchar(30) DEFAULT NULL COMMENT '预约姓名',
  `ytel` char(11) DEFAULT NULL COMMENT '预约电话',
  `num` int(10) unsigned DEFAULT NULL COMMENT '预约人数',
  `create_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '预约状态0未消费1已消费',
  `supplier_id` tinyint(4) DEFAULT '0' COMMENT '0 小程序用户 !0 供应商ID'
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_service_time`
--

CREATE TABLE `box_service_time` (
  `id` int(10) unsigned NOT NULL,
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
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `box_supplier`
--

CREATE TABLE `box_supplier` (
  `id` int(11) unsigned NOT NULL,
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
  `su_adress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商管理';

-- --------------------------------------------------------

--
-- 表的结构 `box_trade`
--

CREATE TABLE `box_trade` (
  `id` int(10) unsigned NOT NULL,
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
  `status` tinyint(4) DEFAULT NULL COMMENT '状态1.未支付2.已支付3.已超时'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `topic_img_id` int(11) DEFAULT NULL COMMENT '外键，关联image表',
  `delete_time` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品类目';

-- --------------------------------------------------------

--
-- 表的结构 `chain`
--

CREATE TABLE `chain` (
  `id` int(10) unsigned NOT NULL,
  `ch_name` varchar(50) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1正常 2停用',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='图片总表';

--
-- 转存表中的数据 `image`
--

INSERT INTO `image` (`id`, `product_id`, `url`, `from`, `delete_time`, `update_time`) VALUES
(1, 1, '/product_img/2@theme-head.png', 1, NULL, NULL),
(2, 1, '/product_img/3@theme.png', 1, NULL, NULL),
(3, 1, '/product_img/category-craft.png', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '外键，用户id，注意并不是openid',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `total_price` decimal(6,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.待支付 2.已支付，待使用 3.已使用',
  `code_img` varchar(255) DEFAULT NULL,
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
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `order_no`, `user_id`, `delete_time`, `create_time`, `total_price`, `status`, `code_img`, `snap_img`, `snap_name`, `total_count`, `update_time`, `snap_items`, `snap_address`, `prepay_id`, `feature`, `express`, `time`, `del`) VALUES
(1, 'AB29483050272132', 1, NULL, NULL, '0.00', 1, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

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

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL COMMENT '商品名称',
  `describe` varchar(80) DEFAULT NULL COMMENT '商品描述',
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
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `name`, `describe`, `content`, `duration`, `address`, `price`, `stock`, `is_pre`, `delete_time`, `unit`, `from`, `create_time`, `update_time`, `del`) VALUES
(1, '留下一篇音乐日记', '录制一首爱的歌曲留下一个美好记忆', '&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px; font-family: &amp;quot;PingFang SC&amp;quot;; color: rgb(51, 51, 51);&quot;&gt;简介&lt;/span&gt;&lt;/strong&gt;&lt;br/&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;轻轻松松学钢琴，零基础也能轻轻松松完整谈曲子，给你提供优美舒适专业的学习场地。&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;br/&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;color: rgb(51, 51, 51);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;商品介绍&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;当你在忙碌的生活中感叹失落与迷惘时。不妨邀上好友，来弹弹琴，唱唱歌，泡上咖啡看看书，你会得到一份意外的收获。&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;a name=&quot;_GoBack&quot;&gt;&lt;/a&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;专门为零基础成人及儿童开发的钢琴教程，来引导学员们真正学会弹钢琴的方法。&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cms.joyfamliy.com/ueditor/php/upload/image/20171011/1507691800112457.jpg&quot; title=&quot;1507691800112457.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cms.joyfamliy.com/ueditor/php/upload/image/20171011/1507691800121012.jpg&quot; title=&quot;1507691800121012.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cms.joyfamliy.com/ueditor/php/upload/image/20171011/1507691800695975.jpg&quot; title=&quot;1507691800695975.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;white-space: normal;&quot;&gt;&lt;img src=&quot;http://cms.joyfamliy.com/ueditor/php/upload/image/20171011/1507691800789761.jpg&quot; title=&quot;1507691800789761.jpg&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;color: rgb(51, 51, 51);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;课程内容&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;指定曲目&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-family: &amp;quot;Times New Roman&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;2&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;首&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-family: &amp;quot;Times New Roman&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;+&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;自选曲目&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-family: &amp;quot;Times New Roman&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;1&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;首&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;流行歌曲：董小姐，空白格，致青春，时间都去哪了&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;爱情歌曲：遇见，画心，安静，滴答&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;经典歌曲：同桌的你，菊花台，莫斯科郊外的晚上&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0cm; white-space: normal;&quot;&gt;&lt;span style=&quot;color: rgb(102, 102, 102);&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;外国歌曲：&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-family: &amp;quot;Times New Roman&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;PingFang SC&amp;quot;, serif;&quot;&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;Right here waiting,Kiss the rain&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;', '2017.08.08-2018.08.08', '北京黑弧数码传媒有限公司', '188.00', 100, 1, NULL, NULL, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `product_describe`
--

CREATE TABLE `product_describe` (
  `id` int(11) NOT NULL,
  `img_id` int(11) DEFAULT NULL COMMENT '外键，关联图片表',
  `content` varchar(255) DEFAULT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '图片排序序号',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product_feature`
--

CREATE TABLE `product_feature` (
  `id` int(11) NOT NULL,
  `feature` varchar(255) DEFAULT '' COMMENT '详情属性名称',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product_property`
--

CREATE TABLE `product_property` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) DEFAULT NULL COMMENT '商品id，外键',
  `course_plan_id` int(10) unsigned DEFAULT NULL COMMENT '课程ID',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product_size`
--

CREATE TABLE `product_size` (
  `id` int(11) NOT NULL,
  `size` varchar(255) DEFAULT '' COMMENT '详情属性名称',
  `price` decimal(6,0) DEFAULT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product_tag`
--

CREATE TABLE `product_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `product_time`
--

CREATE TABLE `product_time` (
  `id` int(11) NOT NULL,
  `start_time` varchar(255) DEFAULT '' COMMENT '详情属性名称',
  `end_time` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `rbac_auth`
--

CREATE TABLE `rbac_auth` (
  `id` int(10) unsigned NOT NULL,
  `auth_name` varchar(30) DEFAULT NULL COMMENT '权限名称',
  `auth_pid` int(11) DEFAULT NULL COMMENT '父级ID',
  `auth_c` varchar(30) DEFAULT NULL COMMENT '控制器',
  `auth_a` varchar(30) DEFAULT NULL COMMENT '方法'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `rbac_role`
--

CREATE TABLE `rbac_role` (
  `id` int(10) unsigned NOT NULL,
  `role_name` varchar(30) DEFAULT NULL COMMENT '角色名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `rbac_role_auth`
--

CREATE TABLE `rbac_role_auth` (
  `id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL COMMENT '角色ID',
  `auth_id` int(11) DEFAULT NULL COMMENT '权限ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `security`
--

CREATE TABLE `security` (
  `id` int(10) unsigned NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `appid` char(10) DEFAULT NULL,
  `secret` char(20) DEFAULT NULL,
  `appkey` char(30) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '专题名称',
  `description` varchar(255) DEFAULT NULL COMMENT '专题描述',
  `shop_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `video_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `date_img_id` int(11) NOT NULL COMMENT '主题图，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `del` tinyint(4) DEFAULT '1' COMMENT '1.启用；2.禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题信息表';

-- --------------------------------------------------------

--
-- 表的结构 `theme_product`
--

CREATE TABLE `theme_product` (
  `theme_id` int(11) NOT NULL COMMENT '主题外键',
  `product_id` int(11) NOT NULL COMMENT '商品外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题所包含的商品';

-- --------------------------------------------------------

--
-- 表的结构 `third_app`
--

CREATE TABLE `third_app` (
  `id` int(11) NOT NULL,
  `app_id` varchar(64) NOT NULL COMMENT '应用app_id',
  `app_secret` varchar(64) NOT NULL COMMENT '应用secret',
  `app_description` varchar(100) DEFAULT NULL COMMENT '应用程序描述',
  `scope` varchar(20) NOT NULL COMMENT '应用权限',
  `scope_description` varchar(100) DEFAULT NULL COMMENT '权限描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问API的各应用账号密码表';

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
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
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型（1普通用户2预约用户3普通+预约）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `country` varchar(20) DEFAULT NULL COMMENT '区',
  `detail` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
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
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_item`
--
ALTER TABLE `banner_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_course`
--
ALTER TABLE `box_course`
  ADD PRIMARY KEY (`sid`),
  ADD KEY `lr_course_interfix_id_Idx` (`interfix_id`,`interfix`);

--
-- Indexes for table `box_course_plan`
--
ALTER TABLE `box_course_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_course_service`
--
ALTER TABLE `box_course_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_course_supplier`
--
ALTER TABLE `box_course_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_member_service`
--
ALTER TABLE `box_member_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_service_time`
--
ALTER TABLE `box_service_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_supplier`
--
ALTER TABLE `box_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`su_name`) USING BTREE;

--
-- Indexes for table `box_trade`
--
ALTER TABLE `box_trade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trade_no` (`trade_no`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chain`
--
ALTER TABLE `chain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_index` (`product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_no` (`order_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_describe`
--
ALTER TABLE `product_describe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_feature`
--
ALTER TABLE `product_feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_property`
--
ALTER TABLE `product_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_time`
--
ALTER TABLE `product_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rbac_auth`
--
ALTER TABLE `rbac_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rbac_role`
--
ALTER TABLE `rbac_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rbac_role_auth`
--
ALTER TABLE `rbac_role_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appid` (`appid`),
  ADD UNIQUE KEY `secret` (`secret`) USING BTREE,
  ADD UNIQUE KEY `appkey` (`appkey`) USING BTREE;

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_product`
--
ALTER TABLE `theme_product`
  ADD PRIMARY KEY (`theme_id`,`product_id`);

--
-- Indexes for table `third_app`
--
ALTER TABLE `third_app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `openid` (`openid`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户表：包括后台管理员、商家会员和普通会员',AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `banner_item`
--
ALTER TABLE `banner_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `box_course`
--
ALTER TABLE `box_course`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `box_course_plan`
--
ALTER TABLE `box_course_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `box_course_service`
--
ALTER TABLE `box_course_service`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `box_course_supplier`
--
ALTER TABLE `box_course_supplier`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `box_member_service`
--
ALTER TABLE `box_member_service`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `box_service_time`
--
ALTER TABLE `box_service_time`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `box_supplier`
--
ALTER TABLE `box_supplier`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `box_trade`
--
ALTER TABLE `box_trade`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chain`
--
ALTER TABLE `chain`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_describe`
--
ALTER TABLE `product_describe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_feature`
--
ALTER TABLE `product_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_property`
--
ALTER TABLE `product_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_time`
--
ALTER TABLE `product_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rbac_auth`
--
ALTER TABLE `rbac_auth`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rbac_role`
--
ALTER TABLE `rbac_role`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rbac_role_auth`
--
ALTER TABLE `rbac_role_auth`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `third_app`
--
ALTER TABLE `third_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

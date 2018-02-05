/*
 Navicat Premium Data Transfer

 Source Server         : artist
 Source Server Type    : MySQL
 Source Server Version : 50638
 Source Host           : 39.104.60.33
 Source Database       : fitness

 Target Server Type    : MySQL
 Target Server Version : 50638
 File Encoding         : utf-8

 Date: 02/04/2018 20:40:03 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `ty_adminuser`
-- ----------------------------
DROP TABLE IF EXISTS `ty_adminuser`;
CREATE TABLE `ty_adminuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户表：包括后台管理员、商家会员和普通会员',
  `name` varchar(20) NOT NULL COMMENT '登陆账号',
  `uname` varchar(10) DEFAULT NULL COMMENT '昵称',
  `pwd` varchar(50) NOT NULL COMMENT 'MD5密码',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  `del` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 1正常2异常',
  `supplier_id` int(11) DEFAULT NULL COMMENT '供应商ID',
  `role_id` int(11) DEFAULT NULL COMMENT '角色ID 权限 1超级管理员 2普通管理员3供应商4运营人员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `ty_collection`
-- ----------------------------
DROP TABLE IF EXISTS `ty_collection`;
CREATE TABLE `ty_collection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `venue_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1 收藏 2 取消收藏',
  `cteate_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `ty_course`
-- ----------------------------
DROP TABLE IF EXISTS `ty_course`;
CREATE TABLE `ty_course` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '课程名称',
  `content` text COMMENT '课程介绍',
  `img_id` varchar(30) DEFAULT NULL COMMENT '课程图片ID',
  `price` decimal(10,2) DEFAULT NULL COMMENT '课程价格',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态 1正常 2异常',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `ty_course_arrange`
-- ----------------------------
DROP TABLE IF EXISTS `ty_course_arrange`;
CREATE TABLE `ty_course_arrange` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ccourse_id` int(11) DEFAULT NULL COMMENT '课程ID',
  `teacher_id` int(11) DEFAULT NULL COMMENT '老师ID',
  `start_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `ty_course_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `ty_course_teacher`;
CREATE TABLE `ty_course_teacher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `teacerh_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `ty_img`
-- ----------------------------
DROP TABLE IF EXISTS `ty_img`;
CREATE TABLE `ty_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_url` varchar(255) DEFAULT NULL,
  `vebue_id` int(11) DEFAULT NULL COMMENT '场馆ID',
  `course_id` int(11) DEFAULT NULL COMMENT '课程ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `ty_img`
-- ----------------------------
BEGIN;
INSERT INTO `ty_img` VALUES ('1', '/Data/UploadFiles/literature/product-yoga@3.jpg', '1', null), ('2', '/Data/UploadFiles/literature/product-yoga@3.jpg', '1', null), ('3', '/Data/UploadFiles/literature/product-yoga@3.jpg', '1', null), ('4', '/Data/UploadFiles/literature/product-yoga@3.jpg', '2', null), ('5', '/Data/UploadFiles/literature/product-yoga@3.jpg', '2', null), ('6', '/Data/UploadFiles/literature/product-yoga@3.jpg', '2', null);
COMMIT;

-- ----------------------------
--  Table structure for `ty_order`
-- ----------------------------
DROP TABLE IF EXISTS `ty_order`;
CREATE TABLE `ty_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` char(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `ty_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `ty_teacher`;
CREATE TABLE `ty_teacher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '老师名称',
  `img` varchar(255) DEFAULT NULL COMMENT '老师图片',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态1正常2异常',
  `craete_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `ty_user`
-- ----------------------------
DROP TABLE IF EXISTS `ty_user`;
CREATE TABLE `ty_user` (
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
  `del` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.启用0.禁用',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `ty_venue`
-- ----------------------------
DROP TABLE IF EXISTS `ty_venue`;
CREATE TABLE `ty_venue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '场馆名称',
  `address` varchar(255) DEFAULT NULL COMMENT '场馆地址',
  `content` text COMMENT '介绍',
  `logo_img` varchar(255) DEFAULT NULL COMMENT 'logo 图片',
  `img_id` varchar(30) DEFAULT NULL COMMENT '课程图片 逗号隔开',
  `longitude` varchar(10) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(10) DEFAULT NULL COMMENT '纬度',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态 1正常 2异常',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `ty_venue`
-- ----------------------------
BEGIN;
INSERT INTO `ty_venue` VALUES ('1', 'yoyoga优瑜伽', '北京市朝阳区百子湾路32号二十二院艺术区6号楼20号', '介绍', '/Data/UploadFiles/literature/product-yoga@3.jpg', '1,2,3', '', null, '1', null, null), ('2', '蓝兔子', '北京市朝阳区百子湾路32号二十二院艺术区6号楼20号', '介绍', '/Data/UploadFiles/literature/product-yoga@3.jpg', '4,5,6', null, null, '1', null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

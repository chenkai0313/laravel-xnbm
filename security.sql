/*
 Navicat Premium Data Transfer

 Source Server         : security-d
 Source Server Type    : MySQL
 Source Server Version : 50636
 Source Host           : 116.62.192.235
 Source Database       : security

 Target Server Type    : MySQL
 Target Server Version : 50636
 File Encoding         : utf-8

 Date: 11/02/2017 16:04:04 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sc_admin_info`
-- ----------------------------
DROP TABLE IF EXISTS `sc_admin_info`;
CREATE TABLE `sc_admin_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `scan_times` int(11) DEFAULT NULL COMMENT '扫描次数',
  `admin_url` varchar(255) DEFAULT NULL COMMENT '网址',
  `risk_level` int(11) DEFAULT '0' COMMENT '风险等级 ：1 绝对安全  2 比较安全  3 相对危险   4 绝对危险 默认0为设置',
  `company_name` varchar(255) DEFAULT NULL COMMENT '单位名称',
  `position` varchar(100) DEFAULT NULL COMMENT '职位',
  `department` varchar(100) DEFAULT NULL COMMENT '部门',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sc_admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `sc_admin_log`;
CREATE TABLE `sc_admin_log` (
  `log_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '后台操作日志记录id',
  `admin_name` varchar(30) NOT NULL COMMENT '管理员名称',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `operate_target` varchar(50) NOT NULL COMMENT '操作模块',
  `operate_ip` varchar(30) DEFAULT '' COMMENT '操作ip',
  `operate_content` longtext COMMENT '日志记录内容（不能记录sql）',
  `operate_time` datetime DEFAULT NULL COMMENT '操作时间',
  `operate_status` tinyint(1) NOT NULL COMMENT '操作状态：1成功，2失败',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15037 DEFAULT CHARSET=utf8 COMMENT='后台操作日志表';

-- ----------------------------
--  Table structure for `sc_admins`
-- ----------------------------
DROP TABLE IF EXISTS `sc_admins`;
CREATE TABLE `sc_admins` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(12) DEFAULT '' COMMENT '账号',
  `admin_nick` varchar(12) DEFAULT '' COMMENT '昵称',
  `admin_sex` tinyint(1) DEFAULT '1' COMMENT '性别（-1保密，1男，0.女）',
  `admin_password` varchar(60) NOT NULL COMMENT '密码',
  `admin_birthday` date DEFAULT NULL COMMENT '生日',
  `admin_mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `remember_token` varchar(100) DEFAULT NULL,
  `is_super` tinyint(1) DEFAULT '0' COMMENT '是否超级管理员（0否，1是）',
  `province` varchar(9) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(9) NOT NULL DEFAULT '' COMMENT '市',
  `district` varchar(9) NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(64) DEFAULT '' COMMENT '详细地址',
  `login_ip` varchar(64) DEFAULT '' COMMENT '最后登录ip',
  `login_at` timestamp NULL DEFAULT NULL COMMENT '最后登录时间',
  `remark` varchar(64) DEFAULT '' COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
--  Table structure for `sc_encrypt_token`
-- ----------------------------
DROP TABLE IF EXISTS `sc_encrypt_token`;
CREATE TABLE `sc_encrypt_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '' COMMENT '项目名',
  `token` varchar(128) DEFAULT '' COMMENT 'token值',
  `publickey_path` varchar(255) DEFAULT '' COMMENT '公钥路径',
  `is_used` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否适用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='RSA加密、解密秘钥';

-- ----------------------------
--  Table structure for `sc_inmail`
-- ----------------------------
DROP TABLE IF EXISTS `sc_inmail`;
CREATE TABLE `sc_inmail` (
  `inmail_id` int(11) NOT NULL AUTO_INCREMENT,
  `inmail_title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题',
  `inmail_content` text NOT NULL COMMENT '站内信内容',
  `sender_id` int(11) NOT NULL COMMENT '发件人id(创建人)',
  `receiver_id` int(11) NOT NULL COMMENT '收件人ID',
  `status_at` timestamp NULL DEFAULT NULL COMMENT '(读取时间 当状态从未读到已读)',
  `status` tinyint(1) DEFAULT '0' COMMENT '发送状态（是否已经读取 0未读 1已读 ）',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`inmail_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `sc_notices`
-- ----------------------------
DROP TABLE IF EXISTS `sc_notices`;
CREATE TABLE `sc_notices` (
  `notice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notice_title` varchar(50) DEFAULT '' COMMENT '标题',
  `notice_content` varchar(255) DEFAULT '' COMMENT '内容',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作者ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`notice_id`),
  UNIQUE KEY `notice_id` (`notice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sc_permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `sc_permission_role`;
CREATE TABLE `sc_permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `sc_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `sc_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sc_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `sc_permissions`;
CREATE TABLE `sc_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT '',
  `description` varchar(255) DEFAULT '',
  `pid` int(10) DEFAULT '0' COMMENT '父级ID',
  `level` tinyint(1) DEFAULT '1' COMMENT '栏目所属层级',
  `path` varchar(255) DEFAULT '' COMMENT '页面url',
  `show` tinyint(1) DEFAULT '0' COMMENT '是否显示 0 不显示 1显示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sc_receipt`
-- ----------------------------
DROP TABLE IF EXISTS `sc_receipt`;
CREATE TABLE `sc_receipt` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '回执 prikey',
  `report_id` int(11) NOT NULL DEFAULT '0' COMMENT '报告id',
  `report_info` varchar(255) DEFAULT NULL COMMENT '暂定 回执的信息或者留言',
  `admin_id` int(11) DEFAULT NULL COMMENT '回复给谁',
  `file_name` varchar(255) DEFAULT '' COMMENT '回执附件名',
  `file_path` varchar(255) DEFAULT '' COMMENT '回执附件路径',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='回执流水表';

-- ----------------------------
--  Table structure for `sc_report`
-- ----------------------------
DROP TABLE IF EXISTS `sc_report`;
CREATE TABLE `sc_report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '报告ID',
  `report_type` varchar(255) DEFAULT NULL COMMENT '公文类型',
  `report_name` varchar(255) DEFAULT NULL COMMENT '公文名称',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '发送人',
  `report_title` varchar(255) DEFAULT NULL COMMENT '报告标题',
  `deal_opinion` varchar(255) DEFAULT '' COMMENT '处理意见',
  `to_admin_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '接收人 0,1,2,3',
  `status` int(5) NOT NULL DEFAULT '0' COMMENT '状态 暂定0未读，1已读，2已回执，3回执未通过，4审核通过',
  `admin_name` varchar(255) DEFAULT '' COMMENT '业主名称',
  `file_name` varchar(255) DEFAULT '' COMMENT '附件文件名',
  `file_path` varchar(255) DEFAULT '' COMMENT '附件path',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='报告基础表';

-- ----------------------------
--  Table structure for `sc_role_admin`
-- ----------------------------
DROP TABLE IF EXISTS `sc_role_admin`;
CREATE TABLE `sc_role_admin` (
  `admin_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`admin_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_admin_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `sc_admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `sc_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sc_roles`
-- ----------------------------
DROP TABLE IF EXISTS `sc_roles`;
CREATE TABLE `sc_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `r_level` int(11) DEFAULT '1' COMMENT 'role等级 1 2 ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sc_system_region`
-- ----------------------------
DROP TABLE IF EXISTS `sc_system_region`;
CREATE TABLE `sc_system_region` (
  `region_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '主键ID,自增',
  `region_code` varchar(9) DEFAULT '' COMMENT '区域编码',
  `parent_id` varchar(9) DEFAULT '' COMMENT '父级编码',
  `region_name` varchar(50) DEFAULT '' COMMENT '区域名称',
  `region_level` tinyint(1) DEFAULT '0' COMMENT '区域等级',
  PRIMARY KEY (`region_id`),
  UNIQUE KEY `region_code` (`region_code`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全国省市区街道表';

-- ----------------------------
--  Table structure for `sc_work_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `sc_work_schedule`;
CREATE TABLE `sc_work_schedule` (
  `schedule_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '排班id',
  `schedule_date` date DEFAULT NULL COMMENT '排班时间（某天）',
  `schedule_time_begin` timestamp NULL DEFAULT NULL COMMENT '当天排班-开始时间',
  `schedule_time_end` timestamp NULL DEFAULT NULL COMMENT '当天排班-结束时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='排班表';

-- ----------------------------
--  Table structure for `sc_work_schedule_allot`
-- ----------------------------
DROP TABLE IF EXISTS `sc_work_schedule_allot`;
CREATE TABLE `sc_work_schedule_allot` (
  `allot_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '排排班分配id班id',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联用户id|admin_id',
  `schedule_id` int(11) DEFAULT NULL COMMENT '排班id',
  `time_begin` timestamp NULL DEFAULT NULL COMMENT '上班时间',
  `time_end` timestamp NULL DEFAULT NULL COMMENT '下班时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`allot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='排班关联表';

SET FOREIGN_KEY_CHECKS = 1;

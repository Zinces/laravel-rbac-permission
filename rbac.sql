/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost
 Source Database       : rbac

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : utf-8

 Date: 05/06/2019 19:25:18 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `permission`
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `routes` text COMMENT '路由别名，逗号分隔',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='permission权限组';

-- ----------------------------
--  Records of `permission`
-- ----------------------------
BEGIN;
INSERT INTO `permission` VALUES ('1', 'admin.user.index', 'fea', '2019-05-06 11:15:48', '2019-05-06 11:15:48'), ('2', 'admin.user.create,admin.user.edit,admin.permission.index,admin.permission.store', 'geafe', '2019-05-06 11:17:07', '2019-05-06 11:17:07'), ('3', 'admin.user.index,admin.user.edit', 'fea1', '2019-05-06 11:20:45', '2019-05-06 11:20:45');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `password` varchar(188) NOT NULL COMMENT '密码',
  `administrator` tinyint(3) DEFAULT '2' COMMENT '是否超管，1是，2否',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态，1启用，2禁用',
  `creator_id` int(11) DEFAULT NULL COMMENT '创建者id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', '2253538281@qq.com', '东东', '$2y$10$BQBE1N73RtjzSuB5J4X1jORxUA0k.iK5gVbxRHXXZq2gp27/gjJVu', '1', '1', '1', '2019-05-05 19:57:01', '2019-05-06 06:41:05'), ('15', '225353281@qq.com', '1', '111111', '1', '2', '1', '2019-05-06 06:26:02', '2019-05-06 06:41:13'), ('16', '232@q.com', '2', '123456', '2', '2', '1', '2019-05-06 06:26:48', '2019-05-06 06:36:14'), ('17', 'fae@q.com', 'feawf', '123123', '1', '2', '1', '2019-05-06 06:27:23', '2019-05-06 06:27:23');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

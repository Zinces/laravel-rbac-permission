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

 Date: 05/09/2019 14:33:00 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `route` varchar(50) DEFAULT NULL COMMENT '路由',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

-- ----------------------------
--  Records of `menu`
-- ----------------------------
BEGIN;
INSERT INTO `menu` VALUES ('1', '菜单2', '0', 'admin.user.create', '2019-05-09 02:41:55', '2019-05-09 03:03:25'), ('2', 'aaa', '1', 'admin.user.status', '2019-05-09 03:04:41', '2019-05-09 03:04:41'), ('3', 'eafeawde', '1', 'admin.user.index', '2019-05-09 05:46:17', '2019-05-09 05:46:17'), ('4', 'gerafea', '0', 'admin.user.status', '2019-05-09 05:46:26', '2019-05-09 05:46:26'), ('5', 'brafea', '0', 'admin.permission.store', '2019-05-09 06:05:57', '2019-05-09 06:05:57');
COMMIT;

-- ----------------------------
--  Table structure for `menu_roles`
-- ----------------------------
DROP TABLE IF EXISTS `menu_roles`;
CREATE TABLE `menu_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='菜单-角色关系表';

-- ----------------------------
--  Records of `menu_roles`
-- ----------------------------
BEGIN;
INSERT INTO `menu_roles` VALUES ('3', '1', '3', '2019-05-09 03:03:25', '2019-05-09 03:03:25'), ('4', '2', '7', '2019-05-09 03:04:41', '2019-05-09 03:04:41'), ('5', '3', '3', '2019-05-09 05:46:17', '2019-05-09 05:46:17'), ('6', '4', '4', '2019-05-09 05:46:26', '2019-05-09 05:46:26'), ('7', '5', '3', '2019-05-09 06:05:57', '2019-05-09 06:05:57'), ('8', '5', '4', '2019-05-09 06:05:57', '2019-05-09 06:05:57'), ('9', '5', '5', '2019-05-09 06:05:57', '2019-05-09 06:05:57'), ('10', '5', '6', '2019-05-09 06:05:57', '2019-05-09 06:05:57'), ('11', '5', '7', '2019-05-09 06:05:57', '2019-05-09 06:05:57');
COMMIT;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='permission权限组';

-- ----------------------------
--  Records of `permission`
-- ----------------------------
BEGIN;
INSERT INTO `permission` VALUES ('1', 'admin.user.index,admin.user.create,admin.user.store,admin.user.status,admin.user.edit', '用户管理', '2019-05-06 11:15:48', '2019-05-07 03:08:59'), ('2', 'admin.permission.index,admin.permission.create,admin.permission.store,admin.permission.edit,admin.permission.update', '权限管理', '2019-05-06 11:17:07', '2019-05-07 03:09:10'), ('3', 'admin.user.index', '用户列表', '2019-05-06 11:20:45', '2019-05-07 03:09:37');
COMMIT;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
--  Records of `roles`
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES ('3', '角色1', '2019-05-07 03:59:12', '2019-05-09 06:21:23'), ('4', 'test', '2019-05-07 03:59:45', '2019-05-07 08:09:26'), ('5', 'aa1', '2019-05-07 03:59:59', '2019-05-07 03:59:59'), ('6', 'test1', '2019-05-07 04:04:12', '2019-05-07 08:13:15'), ('7', 'resa', '2019-05-07 08:19:35', '2019-05-07 08:19:35');
COMMIT;

-- ----------------------------
--  Table structure for `roles_permission`
-- ----------------------------
DROP TABLE IF EXISTS `roles_permission`;
CREATE TABLE `roles_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roles_id` int(10) unsigned NOT NULL COMMENT '角色id',
  `permission_id` int(10) unsigned NOT NULL COMMENT '权限组id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='角色-权限关系表';

-- ----------------------------
--  Records of `roles_permission`
-- ----------------------------
BEGIN;
INSERT INTO `roles_permission` VALUES ('6', '5', '3', '2019-05-07 03:59:59', '2019-05-07 03:59:59'), ('7', '5', '1', '2019-05-07 03:59:59', '2019-05-07 03:59:59'), ('9', '4', '2', '2019-05-07 08:09:26', '2019-05-07 08:09:26'), ('10', '4', '1', '2019-05-07 08:09:26', '2019-05-07 08:09:26'), ('11', '6', '1', '2019-05-07 08:13:15', '2019-05-07 08:13:15'), ('12', '7', '2', '2019-05-07 08:19:35', '2019-05-07 08:19:35'), ('16', '3', '2', '2019-05-09 06:21:23', '2019-05-09 06:21:23'), ('17', '3', '3', '2019-05-09 06:21:23', '2019-05-09 06:21:23'), ('18', '3', '1', '2019-05-09 06:21:23', '2019-05-09 06:21:23');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', '2253538281@qq.com', '东东', '$2y$10$BQBE1N73RtjzSuB5J4X1jORxUA0k.iK5gVbxRHXXZq2gp27/gjJVu', '1', '1', '1', '2019-05-05 19:57:01', '2019-05-06 06:41:05'), ('15', '225353281@qq.com', '1', '111111', '1', '2', '1', '2019-05-06 06:26:02', '2019-05-07 10:26:45'), ('16', '232@q.com', '2', '$2y$10$cRE0Gh23qiDVTC/n42yjD.4D50jLHryvHdTFpNW31yGdwxiPrg.1C', '2', '2', '1', '2019-05-06 06:26:48', '2019-05-07 10:29:19'), ('17', 'fae@q.com', 'feawf', '123123', '1', '2', '1', '2019-05-06 06:27:23', '2019-05-06 06:27:23'), ('18', 'gvfsafew@geaw.com', 'geafea', '$2y$10$XWuGQxHZZvGU5xzmfIG1aOkmz7MnhE57qw0NfSwPmAZMHkpP9kwaK', '1', '1', '1', '2019-05-07 08:36:52', '2019-05-07 10:13:26'), ('20', 'gewafewag@fwa.com', 'vrafea', '$2y$10$gZpGdD8lAUlZ8xF6DK8ZGePN7iqsEd0N7LR0oh4bQUVy0KOB9381q', '1', '1', '1', '2019-05-07 08:38:31', '2019-05-07 08:38:31');
COMMIT;

-- ----------------------------
--  Table structure for `users_roles`
-- ----------------------------
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `roles_id` int(10) unsigned NOT NULL COMMENT '角色id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='用户-角色关系表';

-- ----------------------------
--  Records of `users_roles`
-- ----------------------------
BEGIN;
INSERT INTO `users_roles` VALUES ('5', '18', '5', '2019-05-07 10:13:26', '2019-05-07 10:13:26'), ('6', '18', '6', '2019-05-07 10:13:26', '2019-05-07 10:13:26'), ('20', '16', '5', '2019-05-07 10:29:19', '2019-05-07 10:29:19');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

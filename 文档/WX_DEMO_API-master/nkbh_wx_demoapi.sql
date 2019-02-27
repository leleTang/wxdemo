/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : nkbh_wx_demoapi

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-12-05 14:43:50
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `nkbh_devselfuser`
-- ----------------------------
DROP TABLE IF EXISTS `nkbh_devselfuser`;
CREATE TABLE `nkbh_devselfuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tokenid` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `usertoken` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nkbh_devselfuser
-- ----------------------------
INSERT INTO `nkbh_devselfuser` VALUES ('1', 'admin', 'admin', '1', '1481264213', '9a5d0505196b52609a22e56207d1220a');

-- ----------------------------
-- Table structure for `nkbh_devtoken`
-- ----------------------------
DROP TABLE IF EXISTS `nkbh_devtoken`;
CREATE TABLE `nkbh_devtoken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nkbh_devtoken
-- ----------------------------
INSERT INTO `nkbh_devtoken` VALUES ('1', '8f3e0a21e1a1d017a0233bb4d6592f59', 'q575405657@hotmail.com', '1480650068');

-- ----------------------------
-- Table structure for `nkbh_userarticle`
-- ----------------------------
DROP TABLE IF EXISTS `nkbh_userarticle`;
CREATE TABLE `nkbh_userarticle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `date` int(11) NOT NULL,
  `view` int(11) NOT NULL,
  `text` text,
  `uid` int(11) NOT NULL,
  `tokenid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nkbh_userarticle
-- ----------------------------
INSERT INTO `nkbh_userarticle` VALUES ('2', 'Test', '11111', '0', '这个是测试测试测试', '1', '1', '1');
INSERT INTO `nkbh_userarticle` VALUES ('3', 'Test', '11111', '0', '这个是测试测试测试', '1', '1', '1');
INSERT INTO `nkbh_userarticle` VALUES ('4', 'Test', '3333', '0', '这个是测试测试测试', '1', '1', '1');
INSERT INTO `nkbh_userarticle` VALUES ('5', 'Test', '4444', '0', '这个是测试测试测试', '1', '1', '1');
INSERT INTO `nkbh_userarticle` VALUES ('6', 'Test', '9999', '0', '这个是测试测试测试', '1', '1', '1');
INSERT INTO `nkbh_userarticle` VALUES ('7', 'Test', '1212', '0', '这个是测试测试测试', '1', '1', '0');
INSERT INTO `nkbh_userarticle` VALUES ('8', 'Test', '2323', '0', '这个是测试测试测试', '1', '1', '0');
INSERT INTO `nkbh_userarticle` VALUES ('9', 'Test', '45454', '0', '这个是测试测试测试', '1', '1', '0');

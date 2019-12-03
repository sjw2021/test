/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50640
 Source Host           : 127.0.0.1
 Source Database       : test

 Target Server Type    : MySQL
 Target Server Version : 50640
 File Encoding         : utf-8

 Date: 12/03/2019 17:24:52 PM
*/
CREATE DATABASE IF NOT EXISTS test;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `board`
-- ----------------------------
DROP TABLE IF EXISTS `board`;
CREATE TABLE IF NOT EXISTS `board` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主贴ID',
  `subject` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `Author` varchar(20) NOT NULL DEFAULT '' COMMENT '发帖人',
  `Idate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发帖时间',
  `Replies` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回帖数量',
  `Body` text COMMENT '主贴内容',
  `Ndate` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '最新回复时间',
  `Ip` varchar(15) DEFAULT '' COMMENT 'IP地址',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


SET FOREIGN_KEY_CHECKS = 1;

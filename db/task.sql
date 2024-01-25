/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80024
 Source Host           : localhost:3306
 Source Schema         : vci

 Target Server Type    : MySQL
 Target Server Version : 80024
 File Encoding         : 65001

 Date: 25/01/2024 11:05:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for task
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task`  (
  `id_task` int(0) NOT NULL AUTO_INCREMENT,
  `fk_id_user` int(0) NOT NULL,
  `fk_id_operation` int(0) NOT NULL,
  `fk_id_job` int(0) NOT NULL,
  `fk_id_job_finish` int(0) NOT NULL,
  `task_description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `start` datetime(0) NOT NULL,
  `finish` datetime(0) NOT NULL,
  `working_time` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `working_hours` float NULL DEFAULT 0,
  `working_hours_new` time(0) NULL DEFAULT '00:00:00',
  `regular_hours` float NULL DEFAULT 0,
  `overtime_hours` float NULL DEFAULT 0,
  `observation` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `signature` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `latitude_start` double NULL DEFAULT 0,
  `longitude_start` double NULL DEFAULT 0,
  `address_start` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `latitude_finish` double NULL DEFAULT 0,
  `longitude_finish` double NULL DEFAULT 0,
  `address_finish` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `fk_id_weak_period` int(0) NOT NULL DEFAULT 0,
  `period_status` tinyint(0) NOT NULL DEFAULT 1 COMMENT '1:new register;2:paid',
  PRIMARY KEY (`id_task`) USING BTREE,
  INDEX `fk_id_user`(`fk_id_user`) USING BTREE,
  INDEX `fk_id_operation`(`fk_id_operation`) USING BTREE,
  INDEX `fk_id_job`(`fk_id_job`) USING BTREE,
  INDEX `fk_id_job_finish`(`fk_id_job_finish`) USING BTREE,
  INDEX `fk_id_weak_period`(`fk_id_weak_period`) USING BTREE,
  CONSTRAINT `task_ibfk_1` FOREIGN KEY (`fk_id_job`) REFERENCES `param_jobs` (`id_job`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 25072 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

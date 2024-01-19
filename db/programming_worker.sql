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

 Date: 18/01/2024 22:09:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for programming_worker
-- ----------------------------
DROP TABLE IF EXISTS `programming_worker`;
CREATE TABLE `programming_worker`  (
  `id_programming_worker` int(0) NOT NULL AUTO_INCREMENT,
  `fk_id_programming_user` int(0) NOT NULL,
  `fk_id_programming` int(0) NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `fk_id_machine` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `fk_id_hour` tinyint(1) NOT NULL,
  `site` tinyint(0) NOT NULL COMMENT '1: At the yard; 2: At the site',
  `safety` tinyint(0) NULL DEFAULT NULL COMMENT '1: FLHA; 2: Tool box; 3: JSO',
  `sms_inspection` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:Sin SMS;2:SMS empleado;3:SMS admin',
  `sms_safety` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:Sin SMS;2:SMS empleado;3:SMS admin',
  `confirmation` tinyint(1) NULL DEFAULT 2 COMMENT '1: Yes; 2: No',
  `sms_sent` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1:Yes; 2:No',
  `sms_status` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sms_sid` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `creat_wo` tinyint(1) NULL DEFAULT NULL COMMENT '1:Yes; 2:No',
  `sms_wo` tinyint(1) NULL DEFAULT NULL COMMENT '1:Yes; 2:No',
  `sms_jso` tinyint(1) NULL DEFAULT NULL COMMENT '1:Yes; 2:No',
  PRIMARY KEY (`id_programming_worker`) USING BTREE,
  INDEX `fk_id_programming_user`(`fk_id_programming_user`) USING BTREE,
  INDEX `fk_id_programming`(`fk_id_programming`) USING BTREE,
  INDEX `confirmation`(`confirmation`) USING BTREE,
  INDEX `sms_sent`(`sms_sent`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14271 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

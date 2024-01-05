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

 Date: 05/01/2024 18:35:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bitacora
-- ----------------------------
DROP TABLE IF EXISTS `bitacora`;
CREATE TABLE `bitacora`  (
  `id_bitacora` int(0) NOT NULL AUTO_INCREMENT,
  `fk_id_job` int(0) NOT NULL,
  `fk_id_user` int(0) NOT NULL,
  `date_bitacora` datetime(0) NOT NULL,
  `notification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_bitacora`) USING BTREE,
  INDEX `fk_id_user`(`fk_id_user`) USING BTREE,
  INDEX `fk_id_job`(`fk_id_job`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

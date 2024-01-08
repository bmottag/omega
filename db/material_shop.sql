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

 Date: 07/01/2024 20:02:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for material_shop
-- ----------------------------
DROP TABLE IF EXISTS `material_shop`;
CREATE TABLE `material_shop`  (
  `id_material_shop` int(0) NOT NULL AUTO_INCREMENT,
  `fk_id_material` int(0) NOT NULL,
  `fk_id_shop` int(0) NOT NULL,
  `date` datetime(0) NOT NULL,
  PRIMARY KEY (`id_material_shop`) USING BTREE,
  INDEX `fk_id_material`(`fk_id_material`) USING BTREE,
  INDEX `fk_id_shop`(`fk_id_shop`) USING BTREE,
  CONSTRAINT `fk_id_material` FOREIGN KEY (`fk_id_material`) REFERENCES `param_material_type` (`id_material`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_id_shop` FOREIGN KEY (`fk_id_shop`) REFERENCES `param_shop` (`id_shop`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

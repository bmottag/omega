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

 Date: 20/01/2024 22:44:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for programming_material
-- ----------------------------
DROP TABLE IF EXISTS `programming_material`;
CREATE TABLE `programming_material`  (
  `id_programming_material` int(0) NOT NULL AUTO_INCREMENT,
  `fk_id_programming` int(0) NOT NULL,
  `fk_id_material` int(0) NOT NULL,
  `quantity` float NOT NULL,
  `unit` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_programming_material`) USING BTREE,
  INDEX `fk_id_programming`(`fk_id_programming`) USING BTREE,
  INDEX `fk_id_material`(`fk_id_material`) USING BTREE,
  CONSTRAINT `programming_materials_ibfk_1` FOREIGN KEY (`fk_id_programming`) REFERENCES `programming` (`id_programming`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `programming_materials_ibfk_2` FOREIGN KEY (`fk_id_material`) REFERENCES `param_material_type` (`id_material`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

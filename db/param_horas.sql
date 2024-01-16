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

 Date: 15/01/2024 21:01:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for param_horas
-- ----------------------------
DROP TABLE IF EXISTS `param_horas`;
CREATE TABLE `param_horas`  (
  `id_hora` int(0) NOT NULL AUTO_INCREMENT,
  `hora` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `formato_24` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `order` int(0) NOT NULL,
  PRIMARY KEY (`id_hora`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of param_horas
-- ----------------------------
INSERT INTO `param_horas` VALUES (1, '12:00 AM', '00:00', 1);
INSERT INTO `param_horas` VALUES (2, '12:30 AM', '00:30', 3);
INSERT INTO `param_horas` VALUES (3, '1:00 AM', '01:00', 5);
INSERT INTO `param_horas` VALUES (4, '1:30 AM', '01:30', 7);
INSERT INTO `param_horas` VALUES (5, '2:00 AM', '02:00', 9);
INSERT INTO `param_horas` VALUES (6, '2:30 AM', '02:30', 11);
INSERT INTO `param_horas` VALUES (7, '3:00 AM', '03:00', 13);
INSERT INTO `param_horas` VALUES (8, '3:30 AM', '03:30', 15);
INSERT INTO `param_horas` VALUES (9, '4:00 AM', '04:00', 17);
INSERT INTO `param_horas` VALUES (10, '4:30 AM', '04:30', 19);
INSERT INTO `param_horas` VALUES (11, '5:00 AM', '05:00', 21);
INSERT INTO `param_horas` VALUES (12, '5:30 AM', '05:30', 23);
INSERT INTO `param_horas` VALUES (13, '6:00 AM', '06:00', 25);
INSERT INTO `param_horas` VALUES (14, '6:30 AM', '06:30', 27);
INSERT INTO `param_horas` VALUES (15, '7:00 AM', '07:00', 29);
INSERT INTO `param_horas` VALUES (16, '7:30 AM', '07:30', 31);
INSERT INTO `param_horas` VALUES (17, '8:00 AM', '08:00', 33);
INSERT INTO `param_horas` VALUES (18, '8:30 AM', '08:30', 35);
INSERT INTO `param_horas` VALUES (19, '9:00 AM', '09:00', 37);
INSERT INTO `param_horas` VALUES (20, '9:30 AM', '09:30', 39);
INSERT INTO `param_horas` VALUES (21, '10:00 AM', '10:00', 41);
INSERT INTO `param_horas` VALUES (22, '10:30 AM', '10:30', 43);
INSERT INTO `param_horas` VALUES (23, '11:00 AM', '11:00', 45);
INSERT INTO `param_horas` VALUES (24, '11:30 AM', '11:30', 47);
INSERT INTO `param_horas` VALUES (25, '12:00 PM', '12:00', 49);
INSERT INTO `param_horas` VALUES (26, '12:30 PM', '12:30', 51);
INSERT INTO `param_horas` VALUES (27, '1:00 PM', '13:00', 53);
INSERT INTO `param_horas` VALUES (28, '1:30 PM', '13:30', 55);
INSERT INTO `param_horas` VALUES (29, '2:00 PM', '14:00', 57);
INSERT INTO `param_horas` VALUES (30, '2:30 PM', '14:30', 59);
INSERT INTO `param_horas` VALUES (31, '3:00 PM', '15:00', 61);
INSERT INTO `param_horas` VALUES (32, '3:30 PM', '15:30', 63);
INSERT INTO `param_horas` VALUES (33, '4:00 PM', '16:00', 65);
INSERT INTO `param_horas` VALUES (34, '4:30 PM', '16:30', 67);
INSERT INTO `param_horas` VALUES (35, '5:00 PM', '17:00', 69);
INSERT INTO `param_horas` VALUES (36, '5:30 PM', '17:30', 71);
INSERT INTO `param_horas` VALUES (37, '6:00 PM', '18:00', 73);
INSERT INTO `param_horas` VALUES (38, '6:30 PM', '18:30', 75);
INSERT INTO `param_horas` VALUES (39, '7:00 PM', '19:00', 77);
INSERT INTO `param_horas` VALUES (40, '7:30 PM', '19:30', 79);
INSERT INTO `param_horas` VALUES (41, '8:00 PM', '20:00', 81);
INSERT INTO `param_horas` VALUES (42, '8:30 PM', '20:30', 83);
INSERT INTO `param_horas` VALUES (43, '9:00 PM', '21:00', 85);
INSERT INTO `param_horas` VALUES (44, '9:30 PM', '21:30', 87);
INSERT INTO `param_horas` VALUES (45, '10:00 PM', '22:00', 89);
INSERT INTO `param_horas` VALUES (46, '10:30 PM', '22:30', 91);
INSERT INTO `param_horas` VALUES (47, '11:00 PM', '23:00', 93);
INSERT INTO `param_horas` VALUES (48, '11:30 PM', '23:30', 95);
INSERT INTO `param_horas` VALUES (49, '12:15 AM', '0:15', 2);
INSERT INTO `param_horas` VALUES (50, '12:45 AM', '0:45', 4);
INSERT INTO `param_horas` VALUES (51, '1:15 AM', '1:15', 6);
INSERT INTO `param_horas` VALUES (52, '1:45 AM', '1:45', 8);
INSERT INTO `param_horas` VALUES (53, '2:15 AM', '2:15', 10);
INSERT INTO `param_horas` VALUES (54, '2:45 AM', '2:45', 12);
INSERT INTO `param_horas` VALUES (55, '3:15 AM', '3:15', 14);
INSERT INTO `param_horas` VALUES (56, '3:45 AM', '3:45', 16);
INSERT INTO `param_horas` VALUES (57, '4:15 AM', '4:15', 18);
INSERT INTO `param_horas` VALUES (58, '4:45 AM', '4:45', 20);
INSERT INTO `param_horas` VALUES (59, '5:15 AM', '5:15', 22);
INSERT INTO `param_horas` VALUES (60, '5:45 AM', '5:45', 24);
INSERT INTO `param_horas` VALUES (61, '6:15 AM', '6:15', 26);
INSERT INTO `param_horas` VALUES (62, '6:45 AM', '6:45', 28);
INSERT INTO `param_horas` VALUES (63, '7:15 AM', '7:15', 30);
INSERT INTO `param_horas` VALUES (64, '7:45 AM', '7:45', 32);
INSERT INTO `param_horas` VALUES (65, '8:15 AM', '8:15', 34);
INSERT INTO `param_horas` VALUES (66, '8:45 AM', '8:45', 36);
INSERT INTO `param_horas` VALUES (67, '9:15 AM', '9:15', 38);
INSERT INTO `param_horas` VALUES (68, '9:45 AM', '9:45', 40);
INSERT INTO `param_horas` VALUES (69, '10:15 AM', '10:15', 42);
INSERT INTO `param_horas` VALUES (70, '10:45 AM', '10:45', 44);
INSERT INTO `param_horas` VALUES (71, '11:15 AM', '11:15', 46);
INSERT INTO `param_horas` VALUES (72, '11:45 AM', '11:45', 48);
INSERT INTO `param_horas` VALUES (73, '12:15 PM', '12:15', 50);
INSERT INTO `param_horas` VALUES (74, '12:45 PM', '12:45', 52);
INSERT INTO `param_horas` VALUES (75, '13:15 PM', '13:15', 54);
INSERT INTO `param_horas` VALUES (76, '13:45 PM', '13:45', 56);
INSERT INTO `param_horas` VALUES (77, '14:15 PM', '14:15', 58);
INSERT INTO `param_horas` VALUES (78, '14:45 PM', '14:45', 60);
INSERT INTO `param_horas` VALUES (79, '15:15 PM', '15:15', 62);
INSERT INTO `param_horas` VALUES (80, '15:45 PM', '15:45', 64);
INSERT INTO `param_horas` VALUES (81, '16:15 PM', '16:15', 66);
INSERT INTO `param_horas` VALUES (82, '16:45 PM', '16:45', 68);
INSERT INTO `param_horas` VALUES (83, '17:15 PM', '17:15', 70);
INSERT INTO `param_horas` VALUES (84, '17:45 PM', '17:45', 72);
INSERT INTO `param_horas` VALUES (85, '18:15 PM', '18:15', 74);
INSERT INTO `param_horas` VALUES (86, '18:45 PM', '18:45', 76);
INSERT INTO `param_horas` VALUES (87, '19:15 PM', '19:15', 78);
INSERT INTO `param_horas` VALUES (88, '19:45 PM', '19:45', 80);
INSERT INTO `param_horas` VALUES (89, '20:15 PM', '20:15', 82);
INSERT INTO `param_horas` VALUES (90, '20:45 PM', '20:45', 84);
INSERT INTO `param_horas` VALUES (91, '21:15 PM', '21:15', 86);
INSERT INTO `param_horas` VALUES (92, '21:45 PM', '21:45', 88);
INSERT INTO `param_horas` VALUES (93, '22:15 PM', '22:15', 90);
INSERT INTO `param_horas` VALUES (94, '22:45 PM', '22:45', 92);
INSERT INTO `param_horas` VALUES (95, '23:15 PM', '23:15', 94);
INSERT INTO `param_horas` VALUES (96, '23:45 PM', '23:45', 96);

SET FOREIGN_KEY_CHECKS = 1;

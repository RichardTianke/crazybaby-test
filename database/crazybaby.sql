/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.115
Source Server Version : 50630
Source Host           : 192.168.1.115:3306
Source Database       : crazybaby

Target Server Type    : MYSQL
Target Server Version : 50630
File Encoding         : 65001

Date: 2017-02-16 19:37:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '描述',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '作者',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文章数据表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', 'Test1 Title', 'Hello world, This is a test description.', 'ExactMatcher\n\nMatches an exact string and applies a high multiplier to bring any exact matches to the top.\n\nStartOfStringMatcher\n\nMatches Strings that begin with the search string. For example, a search for \\\'hel\\\' would match; \\\'Hello World\\\' or \\\'helping hand\\\'\n\nAcronymMatcher\n\nMatches strings for Acronym \\\'like\\\' matches but does NOT return Studly Case Matches For example, a search for \\\'fb\\\' would match; \\\'foo bar\\\' or \\\'Fred Brown\\\' but not \\\'FreeBeer\\\'.\n\nConsecutiveCharactersMatcher\n\nMatches strings that include all the characters in the search relatively positioned within the string. It also calculates the percentage of characters in the string that are matched and applies the multiplier accordingly.\n\nFor Example, a search for \\\'fba\\\' would match; \\\'Foo Bar\\\' or \\\'Afraid of bats\\\', but not \\\'fabulous\\\'\n\nStartOfWordsMatcher\n\nMatches the start of each word against each word in a search.\n\nFor example, a search for \\\'jo ta\\\' would match; \\\'John Taylor\\\' or \\\'Joshua B. Takeshi\\\'', 'Test Author', '3', '1', '2017-02-16 08:35:37', '2017-02-16 09:13:12');
INSERT INTO `article` VALUES ('2', 'Fuzzy Search Driver', 'Laravel Searchy makes user driven searching easy with fuzzy search, basic string matching and more to come!', 'Searchy takes advantage of \\\'Drivers\\\' to handle matching various conditions of the fields you specify.\n\nDrivers are simply a specified group of \\\'Matchers\\\' which match strings based on specific conditions.\n\nCurrently there are only three drivers: Simple, Fuzzy and Levenshtein (Experimental).\n\nSimple Search Driver\n\nThe Simple search driver only uses 3 matchers each with the relevant multipliers that best suited my testing environments.', 'Laravel', '2', '1', '2017-02-16 09:03:18', '2017-02-16 09:03:58');

-- ----------------------------
-- Table structure for article_comment
-- ----------------------------
DROP TABLE IF EXISTS `article_comment`;
CREATE TABLE `article_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `article_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '作者',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '评论内容',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '数据状态',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文章评论数据表';

-- ----------------------------
-- Records of article_comment
-- ----------------------------
INSERT INTO `article_comment` VALUES ('1', '1', 'Richard Tian', 'Very good!', '1', '2017-02-16 08:36:01', '2017-02-16 08:36:01');
INSERT INTO `article_comment` VALUES ('2', '1', 'Leif', 'Let me see.', '1', '2017-02-16 08:36:27', '2017-02-16 08:36:27');
INSERT INTO `article_comment` VALUES ('3', '2', 'Allen', 'Let me go!', '1', '2017-02-16 09:03:49', '2017-02-16 09:03:49');
INSERT INTO `article_comment` VALUES ('4', '2', 'Tom', 'I will see', '1', '2017-02-16 09:03:58', '2017-02-16 09:03:58');
INSERT INTO `article_comment` VALUES ('5', '1', 'Jack', 'user name what?', '1', '2017-02-16 09:13:12', '2017-02-16 09:13:12');

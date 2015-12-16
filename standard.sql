/*
SQLyog Ultimate v8.32 
MySQL - 5.6.17 : Database - standards
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`standards` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `standards`;

/*Table structure for table `attachments` */

DROP TABLE IF EXISTS `attachments`;

CREATE TABLE `attachments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `description` tinytext,
  `attachable_type` varchar(20) DEFAULT NULL,
  `attachable_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1159 DEFAULT CHARSET=utf8;

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` mediumtext,
  `user_id` int(10) DEFAULT NULL,
  `commentable_type` varchar(20) DEFAULT NULL,
  `commentable_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=utf8 COMMENT='评论表格';

/*Table structure for table `everyspec` */

DROP TABLE IF EXISTS `everyspec`;

CREATE TABLE `everyspec` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `source_id` varchar(200) DEFAULT NULL,
  `standard_no` varchar(200) DEFAULT NULL COMMENT '标准号',
  `title` tinytext COMMENT '标准名称',
  `date` varchar(50) DEFAULT NULL COMMENT '标准发布日期',
  `abstract` text COMMENT '摘要',
  `file_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

/*Table structure for table `fileable` */

DROP TABLE IF EXISTS `fileable`;

CREATE TABLE `fileable` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `file_id` int(10) DEFAULT NULL,
  `fileable_type` varchar(20) DEFAULT NULL COMMENT '连接对象的类型',
  `fileable_id` int(10) DEFAULT NULL COMMENT '连接对象的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1076 DEFAULT CHARSET=utf8;

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `url` varchar(250) DEFAULT NULL COMMENT '相关链接',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `standard_number` varchar(50) DEFAULT NULL COMMENT '标准号',
  `updated_at_website` varchar(20) DEFAULT NULL COMMENT '更新时间，可以是网站更新时间，也可以是文件更新时间',
  `commentCount` int(10) DEFAULT '0' COMMENT '评论数量',
  `attachmentCount` int(10) DEFAULT '0' COMMENT '附件数量',
  `linkCount` int(10) DEFAULT '0' COMMENT '链接数量',
  `type` varchar(50) DEFAULT NULL COMMENT '文档类型',
  `relationCount` int(10) DEFAULT '0' COMMENT '关系数量，参考+引文',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43951 DEFAULT CHARSET=utf8;

/*Table structure for table `link` */

DROP TABLE IF EXISTS `link`;

CREATE TABLE `link` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(500) DEFAULT NULL COMMENT 'url地址',
  `note` varchar(255) DEFAULT NULL COMMENT '注释',
  `linkable_type` varchar(50) DEFAULT NULL,
  `linkable_id` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8;

/*Table structure for table `oai_dtic_mil` */

DROP TABLE IF EXISTS `oai_dtic_mil`;

CREATE TABLE `oai_dtic_mil` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `source_id` varchar(20) DEFAULT NULL COMMENT '主键：用来获取文件的序列号',
  `Title` tinytext,
  `Descriptive_Note` varchar(50) DEFAULT NULL COMMENT '文档的类型',
  `Corporate_Author` varchar(100) DEFAULT NULL COMMENT '发文单位',
  `Personal_Author` varchar(100) DEFAULT NULL COMMENT '作者',
  `PDF_Url` varchar(200) DEFAULT NULL COMMENT 'pdf文件下载地址',
  `Report_Date` varchar(50) DEFAULT NULL COMMENT '发布日期',
  `Pagination_or_Media_Count` int(10) DEFAULT NULL COMMENT '页数',
  `Abstract` mediumtext COMMENT '摘要',
  `Descriptors` varchar(200) DEFAULT NULL COMMENT '文档内容的标签',
  `Subject_Categories` varchar(200) DEFAULT NULL COMMENT '主题的类别',
  `Distribution_Statement` varchar(50) DEFAULT NULL COMMENT '流通',
  `file_id` int(10) DEFAULT NULL COMMENT 'Files中的关联主键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=407 DEFAULT CHARSET=utf8 COMMENT='用来保存DOD文件的数据表';

/*Table structure for table `relationship` */

DROP TABLE IF EXISTS `relationship`;

CREATE TABLE `relationship` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `start_point` int(10) DEFAULT NULL COMMENT '关系的开始点',
  `end_point` int(10) DEFAULT NULL COMMENT '关系的终点',
  `type` varchar(10) DEFAULT NULL COMMENT '关系的类型：引文关系还是相关关系',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8;

/*Table structure for table `revisions` */

DROP TABLE IF EXISTS `revisions`;

CREATE TABLE `revisions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `file_id` int(10) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8;

/*Table structure for table `taggables` */

DROP TABLE IF EXISTS `taggables`;

CREATE TABLE `taggables` (
  `tag_id` int(10) unsigned NOT NULL,
  `taggable_id` int(10) unsigned NOT NULL,
  `taggable_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '后增加的主键',
  `user_id` int(10) DEFAULT NULL COMMENT '谁增加的标签',
  PRIMARY KEY (`id`),
  KEY `taggables_tag_id_index` (`tag_id`),
  KEY `taggables_taggable_id_index` (`taggable_id`),
  CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1293 DEFAULT CHARSET=utf8;

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8_unicode_ci,
  `commentCount` int(10) DEFAULT '0' COMMENT '评论数量',
  `taggableCount` int(10) DEFAULT '0' COMMENT '打标签的数量',
  `attachmentCount` int(10) DEFAULT NULL COMMENT '附件的数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `wanfang` */

DROP TABLE IF EXISTS `wanfang`;

CREATE TABLE `wanfang` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `source_id` varchar(50) DEFAULT NULL COMMENT '万方的Id，在web地址上的Id标识',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `english_title` varchar(200) DEFAULT NULL COMMENT '英文标题',
  `abstract` mediumtext COMMENT '摘要',
  `doi` varchar(200) DEFAULT NULL COMMENT 'doi标识，可以生成url的',
  `Personal_Author` varchar(50) DEFAULT NULL COMMENT '作者',
  `Corporate_Author` varchar(100) DEFAULT NULL COMMENT '单位',
  `Journal` varchar(100) DEFAULT NULL COMMENT '刊名',
  `yearMonthNumber` varchar(20) DEFAULT NULL COMMENT '年，卷(期)',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键词',
  `publishDate` varchar(50) DEFAULT NULL COMMENT '在线出版日期',
  `file_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=449 DEFAULT CHARSET=utf8;

/*Table structure for table `wanfangconference` */

DROP TABLE IF EXISTS `wanfangconference`;

CREATE TABLE `wanfangconference` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `source_id` varchar(20) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `abstract` text COMMENT '摘要',
  `Personal_Author` varchar(50) DEFAULT NULL COMMENT '作者',
  `Corporate_Author` varchar(50) DEFAULT NULL COMMENT '作者单位',
  `parent_literature` varchar(100) DEFAULT NULL COMMENT '母体文献',
  `conference_title` varchar(200) DEFAULT NULL COMMENT '会议名称',
  `conference_date` varchar(20) DEFAULT NULL COMMENT '会议时间',
  `conference_place` varchar(50) DEFAULT NULL COMMENT '会议地点',
  `host_unit` varchar(50) DEFAULT NULL COMMENT '主办单位',
  `keywords` varchar(200) DEFAULT NULL COMMENT '关键词',
  `publishDate` varchar(20) DEFAULT NULL COMMENT '在线出版日期',
  `file_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `wanfangthesis` */

DROP TABLE IF EXISTS `wanfangthesis`;

CREATE TABLE `wanfangthesis` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `source_id` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `abstract` text COMMENT '摘要',
  `doi` varchar(100) DEFAULT NULL COMMENT 'doi序列号',
  `Personal_Author` varchar(50) DEFAULT NULL COMMENT '作者',
  `major` varchar(100) DEFAULT NULL COMMENT '学科专业',
  `degree` varchar(100) DEFAULT NULL COMMENT '授予学位',
  `school` varchar(100) DEFAULT NULL COMMENT '学位授予单位',
  `supervisor` varchar(100) DEFAULT NULL COMMENT '导师姓名',
  `year` varchar(100) DEFAULT NULL COMMENT '学位年度',
  `publishDate` varchar(100) DEFAULT NULL COMMENT '在线出版日期',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键词',
  `file_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

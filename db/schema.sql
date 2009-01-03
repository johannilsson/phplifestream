CREATE DATABASE IF NOT EXISTS `lifestream` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE lifestream

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS _VERSION_1_0_0;
CREATE TABLE `_VERSION_1_0_0` (
  `dummy` varchar(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS streams;
CREATE TABLE `streams` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) default NULL,
  `code` varchar(10) NOT NULL,
  `display_content` int(11) default 0,  
  `created_at` DATETIME default NULL,
  `updated_at` DATETIME default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS stream_entries;
CREATE TABLE `stream_entries` (
  `id` int(11) NOT NULL auto_increment,
  `stream_id` int(11) NOT NULL,
  `url` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `summary` text default NULL,
  `content_id` varchar(255) NOT NULL,
  `content_id_hash` varchar(32) NOT NULL,
  `content` text default NULL,
  `content_created_at` DATETIME default NULL,
  `content_updated_at` DATETIME default NULL,
  `created_at` DATETIME default NULL,
  `updated_at` DATETIME default NULL,
  PRIMARY KEY  (`id`),
  CONSTRAINT `fk_streams_stream_id` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1
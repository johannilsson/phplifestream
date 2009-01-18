DROP DATABASE IF EXISTS `lifestream`;
CREATE DATABASE IF NOT EXISTS `lifestream` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE lifestream

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS _VERSION_1_0_2;
CREATE TABLE `_VERSION_1_0_2` (
  `dummy` varchar(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS services;
CREATE TABLE `services` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(60) default NULL,
  `name` varchar(255) default NULL,
  `aggregator` varchar(50) NOT NULL,
  `aggregate` tinyint(1) default 1,
  `display_content` tinyint(1) default 0,
  `url` varchar(255) NOT NULL,
  `aggregated_at` DATETIME default NULL,
  `created_at` DATETIME default NULL,
  `updated_at` DATETIME default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS service_options;
CREATE TABLE `service_options` (
  `id` int(11) NOT NULL auto_increment,
  `service_id` int(11) NOT NULL,
  `name` varchar(255) default NULL,
  `value` varchar(255) default NULL,
  `created_at` DATETIME default NULL,
  `updated_at` DATETIME default NULL,
  PRIMARY KEY  (`id`),
  CONSTRAINT `fk_ser_opt_service_id` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS streams;
CREATE TABLE `streams` (
  `id` int(11) NOT NULL auto_increment,
  `unique_id` varchar(40) NOT NULL,
  `url` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `summary` text default NULL,
  `content` text default NULL,
  `content_created_at` DATETIME default NULL,
  `content_updated_at` DATETIME default NULL,
  `content_unique_id` varchar(255) NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` DATETIME default NULL,
  `updated_at` DATETIME default NULL,
  PRIMARY KEY  (`id`),
  CONSTRAINT `fk_streams_service_id` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS tags;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `clean_name` varchar(50) default NULL,
  `created_at` DATETIME default NULL,
  `updated_at` DATETIME default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS tagged_streams;
CREATE TABLE `tagged_streams` (
  `tag_id` int(11) NOT NULL,
  `stream_id` int(11) NOT NULL,
  PRIMARY KEY  (`tag_id`,`stream_id`),
  CONSTRAINT `fk_tags_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`),
  CONSTRAINT `fk_streams_streams_id` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1
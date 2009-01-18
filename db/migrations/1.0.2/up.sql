USE lifestream;

DROP TABLE IF EXISTS `_VERSION_1_0_1`;
CREATE TABLE IF NOT EXISTS `_VERSION_MIGRATING_TO_1_0_2` (
  `dummy` varchar(1) default NULL
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

DROP TABLE `_VERSION_MIGRATING_TO_1_0_2`;
CREATE TABLE `_VERSION_1_0_2` (
  `dummy` varchar(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
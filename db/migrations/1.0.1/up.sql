USE lifestream;

DROP TABLE `_VERSION_1_0_0`;
CREATE TABLE `_VERSION_MIGRATING_TO_1_0_1` (
  `dummy` varchar(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE services MODIFY display_content TINYINT(1) default 0;
ALTER TABLE services ADD aggregate TINYINT(1) default 1 AFTER aggregator;
ALTER TABLE streams MODIFY unique_id VARCHAR(40) NOT NULL;
ALTER TABLE streams ADD content_unique_id VARCHAR(255) AFTER content_updated_at;

UPDATE services SET aggregator = "Feed" WHERE aggregator = "feed" ;

DROP TABLE `_VERSION_MIGRATING_TO_1_0_1`;
CREATE TABLE `_VERSION_1_0_1` (
  `dummy` varchar(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cron_option` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL DEFAULT '',
  `value` VARCHAR(127) NOT NULL DEFAULT '',
  `type` SET('int', 'float', 'string') NOT NULL DEFAULT 'int',
  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`),
  UNIQUE `name`(`name`)
)
ENGINE = InnoDB;

ALTER TABLE `cron_option` ADD COLUMN `enabled` TINYINT UNSIGNED NOT NULL DEFAULT 1 AFTER `time`;
ALTER TABLE `cron_option` ADD COLUMN `parent_name` VARCHAR(64) NOT NULL DEFAULT '' AFTER `name`;
ALTER TABLE `cron_option` DROP INDEX `name`,  ADD UNIQUE `name` USING BTREE(`name`, `parent_name`);

ALTER TABLE `search` ADD COLUMN `deleted` TINYINT UNSIGNED NOT NULL DEFAULT 0 AFTER `table_id`;

CREATE TABLE  `cron_method_res` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `param` varchar(64) NOT NULL DEFAULT '',
  `value` varchar(64) NOT NULL DEFAULT '',
  `time` datetime DEFAULT NULL,
  `time_start` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`param`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `cron_method_res` CHANGE COLUMN `param` `method` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
 DROP INDEX `unique`,
 ADD UNIQUE `unique` USING BTREE(`method`);
 
 ALTER TABLE `news_aggregator`.`cron_method_res` CHANGE COLUMN `time` `time_end` DATETIME;
 
 ALTER TABLE `news_aggregator`.`cron_method_res` MODIFY COLUMN `value` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci;
 
 ALTER TABLE `news_aggregator`.`cron_method_res` ADD COLUMN `error` VARCHAR(64) AFTER `time_start`;
 
 

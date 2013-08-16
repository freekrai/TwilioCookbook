CREATE TABLE `user`(
	`ID` bigint(20) NOT NULL AUTO_INCREMENT,
	`name` varchar(150) NOT NULL,
	`email` varchar(150) NOT NULL,
	`password` varchar(150) NOT NULL,
	`phone_number` varchar(128) NOT NULL,
	`sid` varchar(128) NOT NULL,
	`token` varchar(128) NOT NULL,
	`status`  int(10) NOT NULL default '1',
	PRIMARY KEY (`id`),
	KEY (`phone_number`),
	KEY (`name`),
	KEY (`status`)
);

CREATE TABLE `numbers` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL,
  `number` varchar(100) NOT NULL DEFAULT '0',
  `sid` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `incoming` text NOT NULL,
  `sms` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `number` (`number`),
  UNIQUE KEY `sid` (`sid`),
  KEY `label` (`label`),
  KEY `user_id` (`user_id`)
);

CREATE TABLE `lists`(
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `number` varchar(100) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `time` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `number` (`number`,`user_id`),
  KEY `user_id` (`user_id`)
);
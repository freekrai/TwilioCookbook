CREATE TABLE callers(
	`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`conference_id` INT(10) NOT NULL default '0',
	`name` varchar(50) NOT NULL,
	`phone_number` varchar(128) NOT NULL,
	`status`  int(10) NOT NULL default '1',
	PRIMARY KEY (`id`),
	KEY (`phone_number`),
	KEY (`name`),
	KEY (`status`)
);

CREATE TABLE conference(
	`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`code` varchar(10) NOT NULL,
	`name` varchar(25) NOT NULL,
	`casid` varchar(25) NOT NULL,
	`timestamp` int(12) NOT NULL,
	`status`  int(10) NOT NULL default '0',
	`notified` tinyint(4) NOT NULL default '0',	
	PRIMARY KEY (`id`),
	KEY (`name`)
);
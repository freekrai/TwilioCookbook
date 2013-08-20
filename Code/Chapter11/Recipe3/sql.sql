CREATE TABLE `call_log` (
	`ID` bigint(20) NOT NULL AUTO_INCREMENT,
	'msg' text,
	'phonenumber' varchar(25) NOT NULL DEFAULT '',
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`type` varchar(25) NOT NULL,
	`deleted` tinyint(4) NOT NULL DEFAULT '0',
	`status` tinyint(4) NOT NULL DEFAULT '0',
	`photo` varchar(255) NOT NULL,
	PRIMARY KEY (`ID`),
	KEY `deleted` (`deleted`),
	KEY `status` (`status`),
	KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1
CREATE TABLE reminders(
	`ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`message` varchar(140) NOT NULL,
	phone_number varchar(128) NOT NULL,
	phone_number2 varchar(128) NOT NULL,
	`timestamp` int(12) NOT NULL,
	`notified` tinyint(4) NOT NULL default '0',	
	PRIMARY KEY (`id`),
	KEY (`message`),
	KEY (`phone_number`),
	UNIQUE KEY (`message`,`timestamp`,`phone_numer`)
);
CREATE TABLE messages(
	ID int(10) unsigned NOT NULL AUTO_INCREMENT,
	phone_number varchar(128) NOT NULL,
	sms_sid	varchar(200) NOT NULL,
	message varchar(200) NOT NULL,
	`date`	int(12) NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`phone_number`)
);

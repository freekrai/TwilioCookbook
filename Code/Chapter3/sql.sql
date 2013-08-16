CREATE TABLE subscribers(
	ID int(10) unsigned NOT NULL AUTO_INCREMENT,
	phone_number varchar(128) NOT NULL,
	status  int(10) NOT NULL default '1',
	PRIMARY KEY (`id`),
	KEY (`phone_number`),
	KEY (`status`)
);

CREATE TABLE responses(
	ID int(10) unsigned NOT NULL AUTO_INCREMENT,
	phone_number varchar(128) NOT NULL,
	sms_sid	varchar(200) NOT NULL,
	question_id int(10) NOT NULL,
	answer varchar(25) NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`phone_number`)
);

CREATE TABLE survey(
	ID int(10) unsigned NOT NULL AUTO_INCREMENT,
	question varchar(200) NOT NULL,
	answer1 varchar(200) NOT NULL,
	answer2 varchar(200) NOT NULL,
	answer3 varchar(200) NOT NULL,
	answer4 varchar(200) NOT NULL,
	answer5 varchar(200) NOT NULL,
	answer6 varchar(200) NOT NULL,
	status int(10) NOT NULL default '0',
	PRIMARY KEY (`id`),
	KEY (`status`)
);

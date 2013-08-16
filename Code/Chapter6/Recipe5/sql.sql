CREATE TABLE orders(
	ID int(10) unsigned NOT NULL AUTO_INCREMENT,
	order_id varchar(128) NOT NULL,
	phone_number varchar(200) NOT NULL,
	status varchar(128) NOT NULL,
	order_date	int(12) NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`order_id`),
	KEY (`status`)
);

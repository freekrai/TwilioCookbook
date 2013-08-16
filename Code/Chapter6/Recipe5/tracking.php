<?php
	include("config.php");
	include("pdo.class.php");
	include("functions.php");

	if( isset($_POST['Body']) ){
		$phone = $_POST['From'];
		$order_id = strtolower($_POST['Body']);
		$status = order_lookup($order_id);
		print_sms_reply("Your order is currently set at status '".$status."'");
	}else{
		print_sms_reply("Please send us your order id and we will look it up ASAP");
	}
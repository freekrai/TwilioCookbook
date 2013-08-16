<?php
	include("config.php");
	include("pdo.class.php");
	include("functions.php");

	if( isset($_POST['Body']) ){
		$phone = $_POST['From'];
		$phone = str_replace('+','',$phone);
		$message = strtolower($_POST['Body']);
		$sid = $_POST['SmsSid'];
		$now = time();
		$pdo = Db::singleton();
		$sql = "INSERT INTO messages SET `message`='{$message}', `phone_number`='{$phone}', `sms_sid`='{$sid}',`date`='{$now}'";
		$pdo->exec( $sql );
		$msg = "Your message has been recorded";
		print_sms_reply($msg);
	}

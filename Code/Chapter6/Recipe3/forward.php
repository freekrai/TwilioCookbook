<?php
	include 'Services/Twilio.php';

	include("config.php");
	include("functions.php");

	$client = new Services_Twilio($accountsid, $authtoken);

	if( isset($_POST['Body']) ){
		header('Content-Type: text/html');
		$from = $_POST['From'];
		$body = $_POST['Body'];
		$msg = '['.$from.'] ' . $body;
		$msg = substr($msg, 0, 160);
		send_sms($toNumber,$msg);
		print_sms_reply( $canned );
	}

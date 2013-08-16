<?php
include("config.php");
$client = new Services_Twilio($accountsid, $authtoken);
include("functions.php");

if( isset($_POST['Body']) ){
	$sid = $_POST['SmsSid'];
	$phone = $_POST['From'];
	$phone = str_replace('+','',$phone);
	$message = strtolower($_POST['Body']);
	$name = $people[ $phone ];
	if( empty($name) )	$name = $phone;
	$message = '['.$name.'] '.$message;
	foreach ($people as $number => $name) {
		if( $number == $phone )	continue;
		$sid = send_sms($number,$message);
	}
	print_sms_reply("Message delivered");
}
?>
<?php
	session_start();
	include("config.php");
	include("functions.php");
	
	if( isset($_POST['phone']) ){
		$ph = cleanVar( $_POST['phone'], 'phone' );
		$message = cleanVar( $_POST['message'], 'text' );
		$url = $_POST['himg'];
		$tmms = new TwilioMMS($accountsid,$authtoken);
		$smsg = $tmms->sendMessage($ph,$fromNumber,$message,$url);
		header("Location: index.php");
	}
?>
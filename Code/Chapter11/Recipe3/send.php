<?php
	session_start();
	include("config.php");
	include("functions.php");
	
	if( isset($_POST['phone']) ){
		$ph = $_POST['phone'];
		$message = $_POST['message'];
		$url = $_POST['himg'];
		$tmms = new TwilioMMS($accountsid,$authtoken);
		$smsg = $tmms->sendMessage($ph,$fromNumber,$url);
		header("Location: index.php");
	}
?>
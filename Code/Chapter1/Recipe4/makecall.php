<?php
	session_start();
	include 'Services/Twilio.php';
	include("config.php");
 
	$client = new Services_Twilio($accountsid, $authtoken); 
	if (!isset($_REQUEST['called'])) {
		$err = urlencode("Must specify your phone number");
		header("Location: click-to-call.php?msg=$err");
		die;
	}

	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$url = str_replace("makecall.php","",$url);

	$call = $client->account->calls->create($fromNumber, $toNumber, $url.'/callback.php?number=' . $_REQUEST['called']);
	$msg = urlencode("Connecting... ".$call->sid);
	header("Location: click-to-call.php?msg=$msg");
?>
<?php
	include("config.php");
	include("pdo.class.php");
	include 'Services/Twilio.php';
	
	$pdo = Db::singleton();
	$client = new Services_Twilio($accountsid, $authtoken);
	
	$participant = $client->account->conferences->get( $_GET['sid'] )->participants->get( $_GET['cid'] );
	$participant->update(array(
		"Muted" => "False"
	));
	header("Location:view.php?room=".$_GET['sid']);
	exit;

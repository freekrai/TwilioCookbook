<?php
	include("config.php");	
	
	# Include Twilio PHP helper library.
	require('Services/Twilio.php');

	include 'queue.class.php';

	header('Content-type: text/xml');	

	$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
	$url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
	$url .= $_SERVER["REQUEST_URI"];
	$url = dirname( ($url) );

	$queue = new QueueManager($accountsid, $authtoken, $callqueue_sid);
	$queue->connectNextCaller($url . '/agent.php');

?>
<Response />
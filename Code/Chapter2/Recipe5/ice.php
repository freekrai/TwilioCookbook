<?php
	session_start();
	include 'Services/Twilio.php';
	include("config.php");
 
	$client = new Services_Twilio($accountsid, $authtoken);
	$response = new Services_Twilio_Twiml();

	$timeout = 20;
	
	$phonenumbers = array(
		'1234567890',
		'1234567891'	
	);

	$dial = $response->dial(NULL, array(
		'callerId' => $fromNumber
	));
	foreach($phonenumbers as $number){
		$dial->number( $number );
	}
	header ("Content-Type:text/xml"); 
	print $response;
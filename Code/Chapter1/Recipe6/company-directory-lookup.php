<?php
	session_start();
	include 'Services/Twilio.php';
	include 'config.php';
	include('company-directory-map.php');

	$error = false;
	if (isset($_REQUEST['Digits'])){
		$digits = $_REQUEST['Digits'];
	}else{
		$digits='';
	}
	if(strlen($digits)){
		$result = getPhoneNumberByDigits($digits);
		if($result != false){
			$number = getPhoneNumberByExtension($result['extension']);
			$r = new Services_Twilio_Twiml();
			$r->say($result['name']."'s extension is ".$result['extension']." Connecting you now");
			$r->dial($number);
			header ("Content-Type:text/xml");
			print $r;
			exit();
		} else {
			$error=true;
		}
	}
	$r = new Services_Twilio_Twiml();
	if($error)	$r->say("No match found for $digits");
	$g = $r->gather();
	$g->say("Enter the first several digits of the last name of the party you wish to reach, followed by the pound sign");
	$r->say("I did not receive a response from you");
	$r->redirect("company-directory.php");
	header ("Content-Type:text/xml");
	print $r;

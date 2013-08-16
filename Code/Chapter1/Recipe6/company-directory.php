<?php
	session_start();
	include 'Services/Twilio.php';
	include 'config.php';
	include('company-directory-map.php');

	$first = true;

	if (isset($_REQUEST['Digits'])) {
		$digits = $_REQUEST['Digits'];
		if($digits == '*'){
			header("Location: company-directory-lookup?Digits=".$digits);
			exit();
		}
	} else {
		$digits='';
	}
	if( strlen($digits) ){
		$first = false; 
		$phone_number = getPhoneNumberByExtension($digits);
		if($phone_number!=null){
			$r = new Services_Twilio_Twiml();
			$r->say("Thank you, dialing now");
			$r->dial($phone_number);
			header ("Content-Type:text/xml");
			print $r;
			exit();
		}
	}
	$r = new Services_Twilio_Twiml();
	$g = $r->gather();
	if($first){
		$g->say("Thank you for calling Example Incorporated.");
	}else{
		$g->say('I\'m sorry, we could not find the extension ' . $_REQUEST['Digits']);
	}
	$g->say(" If you know your party's extension, please enter the extension now, followed by the pound sign. To search the directory, press star. Otherwise, stay on the line for the receptionist.");
	$r->say("Connecting you to the operator, please stay on the line.");
	$r->dial($receptionist_phone_number);
	header ("Content-Type:text/xml");
	print $r;
	exit;
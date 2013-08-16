<?php
 	include 'Services/Twilio.php';
	include("config.php");
	
	$myemail = 'MYEMAIL@me.com';
	$message = 'Pretend company is not available right now. Please leave a message.';
	$transcribe = true;

	$client = new Services_Twilio($accountsid, $authtoken);
	$response = new Services_Twilio_Twiml();

    // setup from email headers
	$headers = 'From: voicemail@mywebsite.com' . "\r\n" .'Reply-To: voicemail@mywebsite.com' . "\r\n" .'X-Mailer: Twilio Voicemail';

	// grab the to and from phone numbers
	$from = strlen($_REQUEST['From']) ? $_REQUEST['From'] : $_REQUEST['Caller'];
	$to = strlen($_REQUEST['To']) ? $_REQUEST['To'] : $_REQUEST['Called'];
	
	if( strtolower($_REQUEST['TranscriptionStatus']) == "completed") {
		$body = "You have a new voicemail from " . ($from) . "\n\n";
		$body .= "Text of the transcribed voicemail:\n{$_REQUEST['TranscriptionText']}.\n\n";
		$body .= "Click this link to listen to the message:\n{$_REQUEST['RecordingUrl']}.mp3";
		mail($myemail, "New Voicemail Message from " . ($from), $body, $headers);
		die;
	} else if(strtolower($_REQUEST['TranscriptionStatus']) == "failed") {
		$body = "You have a new voicemail from ".($from)."\n\n";
		$body .= "Click this link to listen to the message:\n{$_REQUEST['RecordingUrl']}.mp3";
		mail($myemail, "New Voicemail Message from " . ($from), $body, $headers);
		die;
	} else if(strlen($_REQUEST['RecordingUrl'])) {
		$response->say("Thanks.  Good bye.");
		$response->hangup();
		if(strlen($transcribe) && strtolower($transcribe) != 'true') {
			$body = "You have a new voicemail from ".($from)."\n\n";
			$body .= "Click this link to listen to the message:\n{$_REQUEST['RecordingUrl']}.mp3";
			mail($myemail, "New Voicemail Message from " . ($from), $body, $headers);
		}
	} else {
		$response->say( $message );
		if( $transcribe )
			$params = array("transcribe"=>"true", "transcribeCallback"=>"{$_SERVER['SCRIPT_URI']}");
		else
			$params = array();
		$response->record($params);
	}
	$response->Respond(); 
?>
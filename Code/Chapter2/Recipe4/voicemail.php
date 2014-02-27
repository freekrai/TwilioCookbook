<?php
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);

 	include 'Services/Twilio.php';
	include("config.php");
	
	$myemail = 'MYEMAIL@me.com';
	$message = 'I am not available right now. Please leave a message.';
	$transcribe = true;

	$client = new Services_Twilio($accountsid, $authtoken);

	header("content-type: text/xml");
	$response = new Services_Twilio_Twiml();

    // setup from email headers
	$headers = 'From: voicemail@mywebsite.com' . "\r\n" .'Reply-To: voicemail@mywebsite.com' . "\r\n" .'X-Mailer: Twilio Voicemail';

	// grab the to and from phone numbers
	$from = isset($_REQUEST['From']) ? $_REQUEST['From'] : ( isset($_REQUEST['Caller']) ? $_REQUEST['Caller'] : '' );
	$to = isset($_REQUEST['To']) ? $_REQUEST['To'] : ( isset($_REQUEST['Called']) ? $_REQUEST['Called'] : '' );
	if( isset($_REQUEST['TranscriptionStatus']) ){
		switch( $_REQUEST['TranscriptionStatus'] ){
			case "completed":
				$body = "You have a new voicemail from " . ($from) . "\n\n";
				$body .= "Text of the transcribed voicemail:\n{$_REQUEST['TranscriptionText']}.\n\n";
				$body .= "Click this link to listen to the message:\n{$_REQUEST['RecordingUrl']}.mp3";
				mail($myemail, "New Voicemail Message from " . ($from), $body, $headers);
				die;
				break;
			case "failed":
				$body = "You have a new voicemail from ".($from)."\n\n";
				$body .= "Click this link to listen to the message:\n{$_REQUEST['RecordingUrl']}.mp3";
				mail($myemail, "New Voicemail Message from " . ($from), $body, $headers);
				die;
				break;
		}
	}else if( isset($_REQUEST['RecordingUrl']) ) {
		$response->say("Thanks.  Good bye.");
		$response->hangup();
		if(isset($transcribe) && strtolower($transcribe) != 'true') {
			$body = "You have a new voicemail from ".($from)."\n\n";
			$body .= "Click this link to listen to the message:\n{$_REQUEST['RecordingUrl']}.mp3";
			mail($myemail, "New Voicemail Message from " . ($from), $body, $headers);
		}
	} else {
		$response->say( $message );
		if( $transcribe )
			$params = array("transcribe"=>"true", "transcribeCallback"=>"voicemail.php");
		else
			$params = array();
		$response->record($params);
	}
	echo $response; 
?>

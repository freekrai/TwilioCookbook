<?php
	include("config.php");
	# Include Twilio PHP helper library.
	require('Services/Twilio.php');
	
	# Tell Twilio to expect some XML
	header('Content-type: text/xml');
	
	# Create response object.
	$response = new Services_Twilio_Twiml();
	
	$response->enqueue( $callqueue );
	
	# Print TwiML
	print $response;
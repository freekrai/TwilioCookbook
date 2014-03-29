<?php
	include("config.php");
	require('Services/Twilio.php');
	 
	# Tell Twilio to expect some XML
	header('Content-type: text/xml');
	 
	# Create response object.
	$response = new Services_Twilio_Twiml();
	 
	# Dial into the Queue we placed the caller into to connect agent to
	# first person in the Queue.
	$dial = $response->dial();
	$dial->queue( $callqueue );
	 
	# Print TwiML
	print $response;
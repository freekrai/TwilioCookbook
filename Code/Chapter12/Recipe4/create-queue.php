<?php
	include("config.php");	
	
	# Include Twilio PHP helper library.
	require('Services/Twilio.php');

	$client = new Services_Twilio($accountsid, $authtoken); 
 
	$queue = $client->account->queues->create( $callqueue, array());
	echo $queue->sid;
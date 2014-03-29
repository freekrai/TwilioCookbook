<?php
	include("config.php");	
	# Include Twilio PHP helper library.
	require('Services/Twilio.php');

	$client = new Services_Twilio($accountsid, $authtoken); 
 
	$queue = $client->account->queues->get("QU32a3c49700934481addd5ce1659f04d2");
	$queue->update(array(
		"MaxSize" => "150"
	));
	echo $queue->average_wait_time;

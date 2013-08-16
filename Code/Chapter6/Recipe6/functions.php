<?php
	function send_sms($number,$message){
		global $client,$fromNumber;
		$sms = $client->account->sms_messages->create(
			$fromNumber, 
			$number,
			$message
		);
		return $sms->sid;
	}
	function print_sms_reply ($sms_reply){
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";    
		echo "<Response>\n<Sms>\n";
		echo $sms_reply;
		echo "</Sms></Response>\n";
	}

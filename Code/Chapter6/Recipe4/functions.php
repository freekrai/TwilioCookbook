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
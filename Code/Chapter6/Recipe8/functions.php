<?php

	function check_site($url){
		if( !filter_var($url, FILTER_VALIDATE_URL) ){
			return false;
		}
		$cl = curl_init($url);
		curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($cl,CURLOPT_HEADER,true);
		curl_setopt($cl,CURLOPT_NOBODY,true);
		curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($cl);
		curl_close($cl);
		if ($response) return true;
		return false;
	}


	function send_sms($number,$message){
		global $client,$fromNumber;
		$sms = $client->account->sms_messages->create(
			$fromNumber, 
			$number,
			$message
		);
		return $sms->sid;
	}
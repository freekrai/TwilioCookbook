<?php
	include('Services/Twilio.php');
	include("config.php");
	include("datastore.class.php");
	include("functions.php");

	$client = new Services_Twilio($accountsid, $authtoken);
	$datastore = new DataStore('check_sites');

	foreach($sites as $url=>$name){
		if( !check_site($url) ){
			$datastore->Set($url,'down',0);
			$message = "Oops! The site found at {$url} seems to be down!";
			foreach($people as $number=>$person){
				send_sms($number,$message);
			}
		}else{
			$last = $datastore->Get($url);
			if( $last == 'down' ){
				$message = "Yay! The site found at {$url} seems to be back up!";
				foreach($people as $number=>$person){
					send_sms($number,$message);
				}
			}
			$datastore->Set($url,'up',0);
		}
	}
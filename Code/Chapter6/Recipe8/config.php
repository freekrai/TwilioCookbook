
<?php
	session_start();
	$accountsid = '';	//	YOUR TWILIO ACCOUNT SID
	$authtoken = '';	//	YOUR TWILIO AUTH TOKEN
	$fromNumber = '';	//	PHONE NUMBER CALLS WILL COME FROM

	//	people to send a message to in case of a site being down...
	$people = array(
		"+14158675309" => "Curious George",
		"+14158675310" => "Boots",
		"+14158675311" => "Virgil",
	);
	
	//	sites to check...
	$sites = array(
		“http://google.com”=> “Google”,
		“http://yahoo.com”=>”Yahoo”,
		“http://starbucks.com”=>”Star Bucks”
	);

?>

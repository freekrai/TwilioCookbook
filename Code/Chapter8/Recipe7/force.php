<?php
	session_start();
	include 'Services/Twilio.php';
	include("config.php");
	require_once ('Services/soapclient/SforceEnterpriseClient.php');


	$message = "{{name}} Try our new hot and ready pizza!";


	$client = new Services_Twilio($accountsid, $authtoken);

	$mySforceConnection = new SforceEnterpriseClient();
	$mySforceConnection->createConnection("Services/soapclient/enterprise.wsdl.xml");
	$mySforceConnection->login(SF_USERNAME, SF_PASSWORD.SF_SECURITY_TOKEN);
	
	$query = "SELECT Id, FirstName, LastName, Phone from Contact";
	$response = $mySforceConnection->query($query);
	
	echo "Results of query '$query'<br/><br/>\n";
	foreach ($response->records as $record) {
		echo "Sending message to ".$record->FirstName . " " . $record->LastName . " at " . $record->Phone . "<br/>\n";
		$msg = str_replace("{{name}}",$record->FirstName,$message);
		$sid = send_sms($record->Phone, $msg);
	}
	exit;

	function send_sms($number,$message){
		global $client,$fromNumber;
		$sms = $client->account->sms_messages->create(
			$fromNumber, 
			$number,
			$message
		);
		return $sms->sid;
	}
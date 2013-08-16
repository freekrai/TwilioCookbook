<?php
	include 'Services/Twilio.php';
	include("config.php");
	$client = new Services_Twilio($accountsid, $authtoken);

	$PhoneNumber = $_POST['PhoneNumber'];
	try {
		$number = $client->account->incoming_phone_numbers->create(array(
			'PhoneNumber' => $PhoneNumber
		));
	} catch (Exception $e) {
		$err = urlencode("Error purchasing number: {$e->getMessage()}");
		header("Location: buy-phone-number.php?msg=$err");
		exit(0);
	}
	$msg = urlencode("Thank you for purchasing $PhoneNumber");
	header("Location: buy-phone-number.php?msg=$msg");
	exit(0);
	break;
?>
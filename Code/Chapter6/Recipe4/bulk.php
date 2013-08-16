<?php
include('Services/Twilio.php');
include("config.php");
include("functions.php");
$client = new Services_Twilio($accountsid, $authtoken);

$people = array(
	"+14158675309" => "Curious George",
	"+14158675310" => "Boots",
	"+14158675311" => "Virgil",
);

$message = "{{name}} Try our new hot and ready pizza!";

foreach ($people as $number => $name) {
	$message = str_replace("{{name}}",$name,$message);
	$sid = send_sms($number, $message);
}
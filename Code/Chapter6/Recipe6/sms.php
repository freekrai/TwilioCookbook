<!DOCTYPE html>
<html>
<head>
<title>Recipe 5 – Chapter 6</title>
</head>
<body>
<?php
include('Services/Twilio.php');
include("config.php");
include("functions.php");

$client = new Services_Twilio($accountsid, $authtoken);
include("functions.php");

if( isset($_POST['message']) ){
	foreach ($people as $number => $name) {
		$sid = send_sms($number,$_POST['message']);
	}
}
?>
<form method="post">
<input type="text" name="message" placeholder="Message...." /><br />
<button type="submit">Send Message</button>
</form>
</body>
</html>
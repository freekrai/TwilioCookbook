<!DOCTYPE html>
<html>
<head>
<title>Recipe 1 – Chapter 6</title>
</head>
<body>
<?php
include('Services/Twilio.php');
include("config.php");
include("functions.php");
$client = new Services_Twilio($accountsid, $authtoken);

if( isset($_POST['number']) && isset($_POST['message']) ){
	$sid = send_sms($_POST['number'],$_POST['message']);
	echo "Message sent to {$_POST['number']}";
}
?>
<form method="post">
<input type="text" name="number" placeholder="Phone Number...." /><br />
<input type="text" name="message" placeholder="Message...." /><br />
<button type="submit">Send Message</button>
</form>
</body>
</html>
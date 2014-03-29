<?php
	include("config.php");
	include 'Services/Twilio/Capability.php';
  
	$capability = new Services_Twilio_Capability($accountsid, $authtoken);

	$capability->allowClientOutgoing($appsid);
	$capability->allowClientIncoming($appname);
	$capability->allowClientIncoming($appname);	
	$token = $capability->generateToken();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Incoming Calls</title>
	<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<?php 	include("clientjs.php");	?>
</head>
<body>
	<button class="call" onclick="call();">Call</button>
	<button class="hangup" onclick="hangup();">Hangup</button>
	<div id="log">Loading pigeons...</div>
</body>
</html>
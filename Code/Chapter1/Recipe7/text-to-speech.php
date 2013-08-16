<?php
	require_once('Services/Twilio/Capability.php');
	include("config.php");
	$APP_SID = 'YOUR APP SID';	
	$token = new Services_Twilio_Capability($accountsid, $authtoken);
	$token->allowClientOutgoing($APP_SID);
?>
<html> 
<head> 
	<title>Text-To-Speech</title> 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
	<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
	<script type="text/javascript"> 
		Twilio.Device.setup("<?php echo $token->generateToken();?>",{"debug":true});
		$(document).ready(function() {
			$("#submit").click(function() {
				speak();
			});
		});
		function speak() {
			var dialogue = $("#dialogue").val();
			var voice = $('input:radio[name=voice]:checked').val();
			$('#submit').attr('disabled', 'disabled');
			Twilio.Device.connect({ 'dialogue' : dialogue, 'voice' : voice });
		}
		Twilio.Device.disconnect(function (conn) {
			$('#submit').removeAttr('disabled');
		});
	</script> 
</head> 
<body> 
	<p> 
		<label for="dialogue">Text to be spoken</label> 
		<input type="text" id="dialogue" name="dialogue" size="50"> 
	</p> 
	<p> 
		<label for="voice-male">Male Voice</label> 
		<input type="radio" id="voice-male" name="voice" value="1" checked="checked"> 
		<label for="voice-female">Female Voice</label> 
		<input type="radio" id="voice-female" name="voice" value="2"> 
	</p> 
	<p> 
		<input type="button" id="submit" name="submit" value="Speak to me"> 
	</p> 
</body> 
</html>
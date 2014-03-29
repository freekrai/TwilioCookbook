<?php
	include("config.php");	
	
	# Include Twilio PHP helper library.
	require('Services/Twilio.php');

	header('Content-type: text/xml');	
?>
<Response>
    <Say>Thank you for waiting. You will now be connected to an agent.</Say>
    <Dial action="next-call.php">
        <Number><?= $toNumber ?>></Number>
    </Dial>
</Response>
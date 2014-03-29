<script type="text/javascript">	
	Twilio.Device.setup("<?php echo $token; ?>");
	
	Twilio.Device.ready(function (device) {
		$("#log").text("Ready");
	});
	
	Twilio.Device.error(function (error) {
		$("#log").text("Error: " + error.message);
	});
	
	Twilio.Device.connect(function (conn) {
		$("#log").text("Successfully established call");
	});
	
	Twilio.Device.disconnect(function (conn) {
		$("#log").text("Call ended");
	});
	
	function call() {
		Twilio.Device.connect();
	}
	
	function hangup() {
		Twilio.Device.disconnectAll();
	}
</script>
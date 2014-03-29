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
	
	Twilio.Device.incoming(function (conn) {
		$("#log").text("Incoming connection from " + conn.parameters.From);
		// accept the incoming connection and start two-way audio
		conn.accept();
	});
	
	function call() {
		// get the phone number to connect the call to
		params = {"PhoneNumber": $("#number").val()};
		Twilio.Device.connect(params);
	}
	
	function hangup() {
		Twilio.Device.disconnectAll();
	}
</script>
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
		conn.accept();
	});
	
	function call() {
		params = {"PhoneNumber": $("#number").val(), ,'myname': <?php echo $_SESSION['myname']; ?>};
		Twilio.Device.connect(params);
	}
	
	function hangup() {
		Twilio.Device.disconnectAll();
	}
</script>
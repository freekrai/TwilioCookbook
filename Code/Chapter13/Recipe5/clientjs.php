<script type="text/javascript">
	Twilio.Device.setup("<?php echo $token; ?>");
	Twilio.Device.ready(function (device) {
		$("#log").text("Client '<?php echo $clientName ?>' is ready");
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
	Twilio.Device.presence(function (pres) {
		if (pres.available) {
			$("<li>", {id: pres.from, text: pres.from}).click(function () {
				$("#number").val(pres.from);
				call();
			}).prependTo("#people");
		}else {
			$("#" + pres.from).remove();
		}
	});
	
	function call() {
		params = {"PhoneNumber": $("#number").val()};
		Twilio.Device.connect(params);
	}
	function hangup() {
		Twilio.Device.disconnectAll();
	}
</script>
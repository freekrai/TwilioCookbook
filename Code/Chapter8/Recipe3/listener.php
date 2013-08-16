<?php
	include("config.php");
	include("pdo.class.php");
	$pdo = Db::singleton();

	$now = time();
	$sql = "INSERT INTO calls SET caller='{$_REQUEST['From']}', call_time='{$now}'";
	$pdo->exec( $sql );

	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<Response>
	<Gather action="input.php" numDigits="1">
		<Say>Welcome to my pretend company.</Say>
		<Say>For store hours, press 1.</Say>
		<Say>To speak to an agent, press 2.</Say>
	</Gather>
	<!-- If customer doesn't input anything, prompt and try again. -->
	<Say>Sorry, I didn't get your response.</Say>
	<Redirect>listener.php</Redirect>
</Response>

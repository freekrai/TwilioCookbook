<?php
	include("config.php");
	header('Content-type: text/xml');
?>
 <Response>
	<Dial>
		<Client><?php echo $appname; ?></Client>
	</Dial>
</Response>
<?php
	session_start();
	include 'Services/Twilio.php';
	include("config.php");
	if( isset($_GET['msg']) )	echo $msg;
?>
<h3>Please enter your phone number, and you will be connected to <?=$toNumber?></h3>
<form action="makecall.php" method="post">
<span>Your Number: <input type="text" name="called" /></span>
<input type="submit" value="Connect me!" />
</form>

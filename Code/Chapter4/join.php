<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';
require_once('Services/Twilio/Capability.php');
$pdo = Db::singleton();
$API_VERSION = '2010-04-01';

$APP_SID = 'YOUR APP SID';	

$client = new Services_Twilio($accountsid, $authtoken);
include("joinjs.php");
?>
<form method="POST" id="joinform">
	<label>Press enter the room number to join your conference</label><br />
	<input type="text" name="room" id="room" />
	<button type="submit">Join</button>
</form>
<div id="choices" style="display:none;">
	<a href="#" id="linkbtn">Leave</a>
</div>
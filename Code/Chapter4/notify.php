<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';

$pdo = Db::singleton();
$client = new Services_Twilio($accountsid, $authtoken);

$curtime = strtotime("+1 hour");
$sql = "SELECT * FROM conference where `timestamp` >  $curtime AND notified = 0";

$res = $pdo->query( $sql );
while( $row = $res->fetch() ){
	$msg = "You have a conference call starting in one hour. Please call into ".$conferenceNumber." and enter ".$row['ID']." as your room";
	//	update conference
	$pdo->exec("UPDATE conference SET notified = 1,status=1 WHERE ID='{$row['ID']}';");
	//	cycle through each participant and notify via sms:
	$sql = "SELECT phone_number FROM callers where conference_id='{$row['ID']}";
	$ares = $pdo->query( $sql );
	while( $arow = $ares->fetch() ){
		$ph = $arow['phone_numer'];
		$client->account->sms_messages->create( $fromNumber, $ph, $msg );
	}
}
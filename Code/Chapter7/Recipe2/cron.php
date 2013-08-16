<?php
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';

$pdo = Db::singleton();
$client = new Services_Twilio($accountsid, $authtoken);

$curtime = strtotime("+1 hour");
$curtime2 = strtotime("+2 hour");
$sql = "SELECT * FROM reminders where (`timestamp` BETWEEN  $curtime AND $curtime2) AND notified = 0";

$res = $pdo->query( $sql );
while( $row = $res->fetch() ){
	$msg = "Reminder: ".$row['message']. ' @ '.date('h:i A',$row['timestamp']);;
	$pdo->exec("UPDATE reminders SET notified = 1 WHERE ID='{$row['ID']}';");
	$ph = $row['phone_number'];
	$ph2 = $row['phone_number2'];
	$client->account->sms_messages->create( $fromNumber, $ph, $msg );
	if( !empty($ph2) ){
		$client->account->sms_messages->create( $fromNumber, $ph2, $msg );		
	}
}
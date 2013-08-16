<?php
session_start();
include("config.php");
include("pdo.class.php");
include 'Services/Twilio.php';

$pdo = Db::singleton();
$client = new Services_Twilio($accountsid, $authtoken);

if( strlen($_REQUEST['Digits']) ){
	$_SESSION['room'] = $room = $_REQUEST['Digits'];
	$from = strlen($_REQUEST['From']) ? $_REQUEST['From'] : $_REQUEST['Caller']; 
 	$to = strlen($_REQUEST['To']) ? $_REQUEST['To'] : $_REQUEST['Called'];

	if(strlen($from) == 11 && substr($from, 0, 1) == "1") {            
		$from = substr($from, 1);
	}
	$sql = "SELECT * FROM conference where `ID` = '{$room}'"; 
	$res = $pdo->query( $sql ); 
	$row = $res->fetch();
	// is this user a moderator?
	$sql = "SELECT * FROM callers where `conference_id` = '{$room}' AND 	`phone_number`='{$from}' AND status='1' "; 
	$ares = $pdo->query( $sql ); 
	$arow = $ares->fetch();
	if( $arow['phone_number'] == $from ){
		$_SESSION['mod'] = true;
		header("Location: moderator.php");
		die;
	}else{
		$_SESSION['mod'] = false;
		header("Location: speaker.php");
		die;
	}
}
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<Response>
    <Gather numDigits="3" action="start.php">
        <Say>Press enter the room number to join your conference</Say>
    </Gather>
</Response>
<?php
include('Services/Twilio.php');
include("config.php");
include("functions.php");

if( isset($_POST['Body']) ){
	$phone = $_POST['From'];
	$body = $_POST['Body'];
	$from = $_POST['FromCity'].', '.$_POST['FromState'];
	$body = strtolower( $body );
	$keywords = explode(" ",$body);
	$key = $keywords[0];
	unset( $keywords[0] );
	$keywords = implode(" ",$keywords);
	$key = strtolower( $key );
//	actions
	if( $key == 'showme' ){
		$lines = array();
		$curtime = strtotime("+1 hour");
		$sql = "SELECT * FROM reminders where `timestamp` >  $curtime AND notified = 0";
		$res = $pdo->query( $sql );
		while( $row = $res->fetch() ){
			$lines[] = $row['message'].' - '.date('d/m/Y @ h:i A',$row['timestamp']);
		}
		print_sms_reply ($lines);
	}else{
		$reminder = explode(' - ',$body);
		$msg = $reminder[0];
		$action = $reminder[1];
		$actions = explode(" ",$action);
		if( $actions[0] == 'cancel' ){
		}else if( $actions[0] == 'add' ){
		}else{
			//	new reminder
			$timestamp = strtotime( $action );
			$sql = "INSERT INTO reminders SET `message`='{$msg}',`timestamp`='{$timestamp}',`phone_number`='{$phone}'";
			$pdo = Db::singleton();
			$pdo->exec($sql);
			$qid = $pdo->lastInsertId();
			print_sms_reply(“Your reminder has been set.”);
		}
	}
// 	end actions
}